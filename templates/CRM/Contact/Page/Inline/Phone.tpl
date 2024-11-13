{*
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC. All rights reserved.                        |
 |                                                                    |
 | This work is published under the GNU AGPLv3 license with some      |
 | permitted exceptions and without any warranty. For full license    |
 | and copyright information, see https://civicrm.org/licensing       |
 +--------------------------------------------------------------------+
*}
{* template for building phone block*}
<div id="crm-phone-content" {if $permission EQ 'edit'} class="crm-inline-edit" data-edit-params='{ldelim}"cid": "{$contactId}", "class_name": "CRM_Contact_Form_Inline_Phone"{rdelim}' data-dependent-fields='["#crm-contact-actions-wrapper"]'{/if}>
  <div class="crm-clear crm-inline-block-content" {if $permission EQ 'edit'}title="{ts}Add or edit phone{/ts}"{/if}>
    {if $permission EQ 'edit'}
      <div class="crm-edit-help">
        <span class="crm-i fa-pencil" aria-hidden="true"></span> {if empty($phone)}{ts}Add phone{/ts}{else}{ts}Add or edit phone{/ts}{/if}
      </div>
    {/if}
    {if empty($phone)}
      <div class="crm-summary-row">
        <div class="crm-label">
          {ts}Phone{/ts}
          {privacyFlag field=do_not_sms condition=$privacy.do_not_sms}
          {privacyFlag field=do_not_phone condition=$privacy.do_not_phone}
        </div>
        <div class="crm-content"></div>
      </div>
    {/if}
    {foreach from=$phone item=item}
      {if !empty($item.phone) || !empty($item.phone_ext)}
        <div class="crm-summary-row {if !empty($item.is_primary)}primary{/if}">
          <div class="crm-label">
            {privacyFlag field=do_not_sms condition=$privacy.do_not_sms}
            {privacyFlag field=do_not_phone condition=$privacy.do_not_phone}
            {$item.location_type} {$item.phone_type}
          </div>
          <div class="crm-content crm-contact_phone" id="phone_id_{$item.id}" country_code="{$item.country_code}" data-title='{$item.country_code}'>
            {$item.phone}{if !empty($item.phone_ext)}&nbsp;&nbsp;{ts}ext.{/ts} {$item.phone_ext}{/if}
          </div>
        </div>
      {/if}
    {/foreach}
   </div>
</div>
{literal}
<script type="text/javascript">
  cj('div.crm-contact_phone').each( function() {
    element = cj(this)
    countryCode = cj(this).attr('country_code');
    var flag = countryCodeToFlag(countryCode);
    cj(element).prepend("<span>"+flag+"</span>");
  });
  function countryCodeToFlag(countryCode) {
    // Validate the input to be exactly two characters long and all alphabetic
    if (!countryCode || countryCode.length !== 2 || !/^[a-zA-Z]+$/.test(countryCode)) {
      return '🏳️'; // White Flag Emoji for unknown or invalid country codes
    }

    // Convert the country code to uppercase to match the regional indicator symbols
    const code = countryCode.toUpperCase();

    // Calculate the offset for the regional indicator symbols
    const offset = 127397;

    // Convert each letter in the country code to its corresponding regional indicator symbol
    const flag = Array.from(code).map(letter => String.fromCodePoint(letter.charCodeAt(0) + offset)).join('');

    return flag;
  }
</script>
{/literal}
