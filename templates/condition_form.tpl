{$startform}

<div class="pageoverflow">
  <p class="pagetext">{$title_conditions}</p>
  <p class="pageinput">{$hidden}{$submit}{$cancel}{if isset($apply)}{$apply}{/if}</p>
</div>

<div id="edit_condition">
    <div class="pageoverflow">
        <p class="pagetext">{$nametext}:</p>
        <p class="pageinput">{$nameinput}</p>
    </div>
    
    <div class="pageoverflow">
        <p class="pagetext">{$contenttext}:</p>
        <p class="pageinput">{$contentinput}</p>
    </div>
    
    <div class="pageoverflow">
        <p class="pagetext">{$practitionerstext}:</p>
        <table class="pagetable">
            <tr>
                <th>{$title_practitioners}</th>
                <th>{$order}</th>
            </tr>
            {foreach $practitionerinputs as $input}
                <tr class="{cycle values="row1,row2"}">
                    <td>{$input.text}:</td>
                    <td>{$input.input}</td>
                </tr>
            {/foreach}
        </table>
    </div>
</div>

<div class="pageoverflow">
  <p class="pagetext">{$title_practitioners}</p>
  <p class="pageinput">{$hidden}{$submit}{$cancel}{if isset($apply)}{$apply}{/if}</p>
</div>

{$formend}