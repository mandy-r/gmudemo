<?php

namespace Acquia\Blt\Custom\Commands;

use Acquia\Blt\Robo\BltTasks;

/**
 * Defines commands in the "custom" namespace.
 */
class ExampleCommand extends BltTasks {

  /**
   * Print "Hello world!" to the console.
   *
   * @command custom:hello
   * @description This is an example command.
   */
  public function hello() {
    $this->say("Hello world!");
  }

  /**
   * Uninstalls ACSF settings and hook files.
   *
   * @command recipes:acsf:uninstall
   *
   * @aliases acsf:uninit
   */
  public function acsfDrushUninstall() {
    $this->say('Removing config provided acsf module...');
    $acsf_include = $this->getConfigValue('docroot') . '/modules/contrib/acsf/acsf_init';
    $result = $this->taskExecStack()
      ->exec($this->getConfigValue('repo.root') . "/vendor/bin/drush acsf-uninstall --include=\"$acsf_include\" --root=\"{$this->getConfigValue('docroot')}\" -y")
      ->run();

    if (!$result->wasSuccessful()) {
      throw new BltException("Unable to uninstall ACSF scripts.");
    }

    return $result;
  }

  /**
   * Verifies that acsf-init was successfully run in the current version.
   *
   * @command recipes:acsf:init:verify
   *
   * @aliases acsf:verify
   */
  public function acsfInitVerify() {
    $this->say('Validating that acsf-init has been run');
    $acsf_include = $this->getConfigValue('docroot') . '/modules/contrib/acsf/acsf_init';
    $result = $this->taskExecStack()
      ->exec($this->getConfigValue('repo.root') . "/vendor/bin/drush acsf-init-verify --include=\"$acsf_include\" --root=\"{$this->getConfigValue('docroot')}\" -y")
      ->run();

    if (!$result->wasSuccessful()) {
      throw new BltException("Unable to uninstall ACSF scripts.");
    }

    return $result;
  }

}
