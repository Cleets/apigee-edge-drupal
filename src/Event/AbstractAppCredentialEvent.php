<?php

/**
 * Copyright 2018 Google Inc.
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * version 2 as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 */

namespace Drupal\apigee_edge\Event;

use Apigee\Edge\Api\Management\Entity\AppCredentialInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Base class for app credential create, generate and add products events.
 */
abstract class AbstractAppCredentialEvent extends Event {

  const APP_TYPE_COMPANY = 'company';

  const APP_TYPE_DEVELOPER = 'developer';

  /**
   * @var string
   */
  private $appType;

  /**
   * @var string
   */
  private $ownerId;

  /**
   * @var string
   */
  private $appName;

  /**
   * @var \Apigee\Edge\Api\Management\Entity\AppCredentialInterface
   */
  private $credential;

  /**
   * AppCredentialGenerateEvent constructor.
   *
   * @param string $appType
   *   Either company or developer.
   * @param string $ownerId
   *   Company name or developer id (email) depending on the appType.
   * @param string $appName
   *   Name of the app.
   * @param \Apigee\Edge\Api\Management\Entity\AppCredentialInterface $credential
   *   The app credential that has been created.
   */
  public function __construct(string $appType, string $ownerId, string $appName, AppCredentialInterface $credential) {
    if (!in_array($appType, [self::APP_TYPE_DEVELOPER, self::APP_TYPE_COMPANY])) {
      throw new \InvalidArgumentException('App type must be either company or developer.');
    }
    $this->appType = $appType;
    $this->ownerId = $ownerId;
    $this->appName = $appName;
    $this->credential = $credential;
  }

  /**
   * Returns the app type which is either "company" or "developer".
   *
   * @return string
   *   The app type.
   */
  public function getAppType(): string {
    return $this->appType;
  }

  /**
   * Returns owner id which is either a company name or a developer id (email).
   *
   * @return string
   *   The owner id.
   */
  public function getOwnerId(): string {
    return $this->ownerId;
  }

  /**
   * Returns the name of the app.
   *
   * @return string
   *   The app name.
   */
  public function getAppName(): string {
    return $this->appName;
  }

  /**
   * Returns the app credential.
   *
   * @return \Apigee\Edge\Api\Management\Entity\AppCredentialInterface
   *   The app credential.
   */
  public function getCredential(): AppCredentialInterface {
    return $this->credential;
  }

}
