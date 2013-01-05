{$startform}
<div class="pageoverflow">
  <p class="pagetext">{$title_practitioners}</p>
  <p class="pageinput">{$hidden}{$submit}{$cancel}{if isset($apply)}{$apply}{/if}</p>
</div>
<table class="pagetable">
    <thead>
        <th>Key</th>
        <th>Value</th>
    </thead>
    
    {foreach $settings as $setting}
        <tr class="{cycle values="row1,row2"}">
            <td>{$setting.label}</td>
            <td>{$setting.input}</td>
        </tr>
    {/foreach}
</table>
<div class="pageoverflow">
  <p class="pagetext">{$title_practitioners}</p>
  <p class="pageinput">{$hidden}{$submit}{$cancel}{if isset($apply)}{$apply}{/if}</p>
</div>
{$endform}