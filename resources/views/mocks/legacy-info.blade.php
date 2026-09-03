<style>
    .info_box2 {
        margin: 0 0 10px;
        background-color: #fff;
        border: #900 2px solid;
        font-family: "IwaUDGoDspPro-Th", sans-serif !important;
    }

    #info_div .info_box2 h2 {
        margin: 12px 5px !important;
        color: #333 !important;
        font-size: 15px !important;
        line-height: 20px !important;
        text-align: center !important;
        letter-spacing: .05em !important;
    }

    .info_box2 h2 a {
        color: red;
    }

    .info_box2 p {
        padding: 0 10px 10px !important;
        font-size: 13px !important;
    }
</style>

<div class="info_box2" data-mock="announcement">
    <h2>
        <a href="javascript:void(0)" onclick="$('#info_disp').slideToggle();">【モック】お知らせ</a>
    </h2>
    <div id="info_disp" style="display: none;">
        <p>この欄は、旧システムの <code>hm_announce</code> テーブルへ接続するまでの仮表示です。</p>
    </div>
</div>
