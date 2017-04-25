<?php

namespace Deployer;

require 'recipe/drupal8.php';
require 'vendor/deployer/recipes/slack.php';

set('ssh_type', 'native');
set('ssh_multiplexing', true);
set('repository', 'https://github.com/open-data/site-open-data.git');
set('env_vars', "HTTPS_PROXY=" . getenv('HTTPS_PROXY'));
set('keep_releases', '15');

# Override native deployer composer task for proxy support
# TODO: Determine why isn't detected natively by Deployer.
set('bin/composer', function () {
    if (commandExist('composer')) {
        $composer = run('which composer')->toString();
    }
    if (empty($composer)) {
        run("source ~/.profile && cd {{release_path}} && curl -sS https://getcomposer.org/installer | /opt/rh/rh-php56/root/usr/bin/php");
        $composer = "source ~/.profile && /opt/rh/rh-php56/root/usr/bin/php {{release_path}}/composer.phar";
    }
    return $composer;
});

//Drupal 8 shared dirs
set('shared_dirs', [
    'html/sites/{{drupal_site}}/files',
]);
//Drupal 8 shared files
set('shared_files', [
    'html/sites/{{drupal_site}}/settings.php',
    'html/sites/{{drupal_site}}/services.yml',
]);
//Drupal 8 Writable dirs
set('writable_dirs', [
    'html/sites/{{drupal_site}}/files',
]);

// Server
server(getenv('PROJECT_NAME'), getenv('SSH_HOST'))
    ->user(getenv('SSH_USER'))
    ->identityFile()
    ->forwardAgent()
    ->set('deploy_path', getenv('SSH_PATH'))
    ->stage('develop');

after('deploy','deploy:vendors');

// Slack
set('slack', [
    'channel'  => getenv('SLACK_CHANNEL'),
    'token' => getenv('SLACK_TOKEN'),
    'username' => 'GitLab',
    'team'  => getenv('SLACK_TEAM_NAME'),
    'app'   => getenv('PROJECT_NAME'),
    'icon' => ':whale:',
    'message' => "`{{app_name}}` deployment to `{{host}}` on *{{stage}}* was successful\n(`{{release_path}}`)",
    'proxy' => [
      'user' => getenv('PROXY_USER'),
      'pass' => getenv('PROXY_PASS'),
      'url' => getenv('PROXY_URL'),
    ],
]);

task('deploy:update_code', function () {
    $repository = trim(get('repository'));
    $branch = get('branch');
    $git = get('bin/git');
    $gitCache = get('git_cache');
    $depth = $gitCache ? '' : '--depth 1';
    $options = [
        'tty' => get('git_tty', false),
    ];
    // If option `branch` is set.
    if (input()->hasOption('branch')) {
        $inputBranch = input()->getOption('branch');
        if (!empty($inputBranch)) {
            $branch = $inputBranch;
        }
    }
    // Branch may come from option or from configuration.
    $at = '';
    if (!empty($branch)) {
        $at = "-b $branch";
    }
    // If option `tag` is set
    if (input()->hasOption('tag')) {
        $tag = input()->getOption('tag');
        if (!empty($tag)) {
            $at = "-b $tag";
        }
    }
    // If option `tag` is not set and option `revision` is set
    if (empty($tag) && input()->hasOption('revision')) {
        $revision = input()->getOption('revision');
        if (!empty($revision)) {
            $depth = '';
        }
    }
    if ($gitCache && has('previous_release')) {
        try {
            run("source ~/.profile && $git clone $at --recursive -q --reference {{previous_release}} --dissociate $repository  {{release_path}} 2>&1", $options);
        } catch (\RuntimeException $exc) {
            // If {{deploy_path}}/releases/{$releases[1]} has a failed git clone, is empty, shallow etc, git would throw error and give up. So we're forcing it to act without reference in this situation
            run("source ~/.profile && $git clone $at --recursive -q $repository {{release_path}} 2>&1", $options);
        }
    } else {
        // if we're using git cache this would be identical to above code in catch - full clone. If not, it would create shallow clone.
        run("source ~/.profile && $git clone $at $depth --recursive -q $repository {{release_path}} 2>&1", $options);
    }
    if (!empty($revision)) {
        run("source ~/.profile && cd {{release_path}} && $git checkout $revision");
    }
});

after('deploy','deploy:slack');
