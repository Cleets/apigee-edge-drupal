<?php

/**
 * Copyright 2019 Google Inc.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 2 as published by the
 * Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public
 * License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc., 51
 * Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 */

namespace Drupal\apigee_edge;

use Drupal\apigee_edge\Exception\InvalidArgumentException;
use Drupal\apigee_edge\Plugin\EdgeKeyTypeInterface;
use Drupal\key\KeyInterface;
use Http\Message\Authentication;

/**
 * The API credentials for HybridCredentials.
 */
class HybridCredentials extends Credentials {

  /**
   * HybridCredentials constructor.
   *
   * @param \Drupal\key\KeyInterface $key
   *   The key entity which stores the API credentials.
   *
   * @throws \InvalidArgumentException
   *   An InvalidArgumentException is thrown if the key type
   *   does not implement EdgeKeyTypeInterface.
   */
  public function __construct(KeyInterface $key) {
    if ($key->getKeyType() instanceof EdgeKeyTypeInterface
      && $key->getKeyType()->getInstanceType($key) === EdgeKeyTypeInterface::INSTANCE_TYPE_HYBRID) {
      parent::__construct($key);
    }
    else {
      throw new InvalidArgumentException("The `{$key->id()}` key is not configured for Hybrid Authentication.");
    }
  }

}
