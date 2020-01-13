<?php

/**
 * @file
 * Enables modules and site configuration for the Example Profile profile.
 */

// Add any custom code here like hook implementations.

function PROFILE_form_install_configure_form_alter(&$form, FormStateInterface $form_state) {

  // Account information defaults
  $form['admin_account']['account']['name']['#default_value'] = 'admin';
  $form['admin_account']['account']['mail']['#default_value'] = 'ayush.jaiswal@infobeans.com';

  // Date/time settings
  $form['regional_settings']['site_default_country']['#default_value'] = 'CA';
  $form['regional_settings']['date_default_timezone']['#default_value'] = 'America/Vancouver';

}
