{$startform}

<div class="pageoverflow">
  <p class="pagetext">{$title_questions}</p>
  <p class="pageinput">{$hidden}{$submit}{$cancel}{if isset($apply)}{$apply}{/if}</p>
</div>

<div id="edit_condition">
    <div class="pageoverflow">
        <p class="pagetext">{$questiontext}:</p>
        <p class="pageinput">{$questioninput}</p>
    </div>
    
    <div class="pageoverflow">
        <p class="pagetext">{$contenttext}:</p>
        <p class="pageinput">{$contentinput}</p>
    </div>
    
    <div class="pageoverflow">
        <p class="pagetext">{$locationstext}:</p>
        <table class="pagetable">
            <tr>
                <th>{$title_locations}</th>
                <th>{$selected}</th>
            </tr>
            {foreach $locationinputs as $input}
                <tr class="{cycle values="row1,row2"}">
                    <td>{$input.text}:</td>
                    <td>{$input.input}</td>
                </tr>
            {/foreach}
        </table>
    </div>
        
    <div class="pageoverflow">
        <p class="pagetext">{$conditionstext}</p>
        <table class="pagetable">
            <tr>
                <th>{$title_conditions}</th>
                <th>{$order}</th>
            </tr>
            {foreach $conditioninputs as $input}
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