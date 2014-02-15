<div id="bascontent" class="clear">
    <form action="search" id="basform">
        <a href="#" id="baslang">EN</a>
        <div id="bastext"><input type="text" name="basterm" id="basterm" data-token="<?php echo $token; ?>" placeholder="Enter a word" /></div>
    </form>
</div>
<div id="basresults">
    <p class="notice error hide"> An error has occurred - <span class="dv">މައްސަލައެއް ދިމާވެއްޖެ</span></p>
    <div id="followingBallsG">
        <div id="followingBallsG_1" class="followingBallsG"></div>
        <div id="followingBallsG_2" class="followingBallsG"></div>
        <div id="followingBallsG_3" class="followingBallsG"></div>
        <div id="followingBallsG_4" class="followingBallsG"></div>
    </div>
    <ul>
    </ul>
</div>

<div id="bassuggest">
    <form action="suggest">
        <a id="suggestClose" href="#">x</a>
        <p class="notice error hide"> An error has occurred </p>
        <p class="notice success hide"> Thank you </p>
        <input type="text" name="baseng" placeholder="English Word">
        <input type="text" id="basdhisuggest" name="basdhi" placeholder="ދިވެހި ބަސް">
        <input type="text" name="baslatin" placeholder="Latin Word">
        <div id="bassuggestrecaptcha"></div>
        <button type="submit">Suggest</button>
    </form>
</div>