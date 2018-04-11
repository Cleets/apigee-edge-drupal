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

namespace Drupal\apigee_edge\EventSubscriber;

use Drupal\language\Config\LanguageConfigOverrideCrudEvent;
use Drupal\language\Config\LanguageConfigOverrideEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Clears caches when an Edge entity type's config translation gets updated.
 */
class EdgeEntityConfigTranslationChangeSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      LanguageConfigOverrideEvents::SAVE_OVERRIDE => 'clearCache',
      LanguageConfigOverrideEvents::DELETE_OVERRIDE => 'clearCache',
    ];
  }

  /**
   * Clears caches when an Edge entity type's config translation gets updated.
   *
   * @param \Drupal\language\Config\LanguageConfigOverrideCrudEvent $event
   *   The event object.
   */
  public function clearCache(LanguageConfigOverrideCrudEvent $event) {
    /** @var \Drupal\language\Config\LanguageConfigOverride $override */
    $override = $event->getLanguageConfigOverride();
    $matches = [];
    if (preg_match('/apigee_edge.([a-z_]+)_settings$/', $override->getName(), $matches)) {
      if (\Drupal::entityTypeManager()->hasDefinition($matches[1])) {
        // It is easier to do that rather than just trying to figure our all
        // cache bins and tags that requires invalidation. We tried that.
        drupal_flush_all_caches();
      }
    }
  }

}
