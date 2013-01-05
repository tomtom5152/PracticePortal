{$startform}

<div class="pageoverflow">
  <p class="pagetext">{$title_locations}</p>
  <p class="pageinput">{$hidden}{$submit}{$cancel}{if isset($apply)}{$apply}{/if}</p>
</div>

<div id="edit_location">
    <div class="pageoverflow">
        <p class="pagetext">{$nametext}:</p>
        <p class="pageinput">{$nameinput}</p>
    </div>
    
    <div class="pageoverflow">
        <p class="pagetext">{$posxtext}:</p>
        <p class="pageinput">{$posxinput}</p>
    </div>
    
    <div class="pageoverflow">
        <p class="pagetext">{$posytext}:</p>
        <p class="pageinput">{$posyinput}</p>
    </div>
</div>
    
    <div class="treatmentMan">
        <div id="thisLocation" class="locationSelector" style="top:{$posy}px;left:{$posx}px;"></div>
    </div>

<div class="pageoverflow">
  <p class="pagetext"></p>
  <p class="pageinput">{$hidden}{$submit}{$cancel}{if isset($apply)}{$apply}{/if}</p>
</div>

{literal}
    <script>
        $(document).ready(function() {
            $("input[data-coord]").change(function() {
                var posx = parseInt($("input[data-coord='x']").val());
                var posy = parseInt($("input[data-coord='y']").val());
                $('#thisLocation').css({"top":posy,"left":posx});
            });
        });
    </script>
{/literal}

{$formend}