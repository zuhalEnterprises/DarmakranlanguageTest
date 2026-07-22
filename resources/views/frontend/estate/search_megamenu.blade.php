<div id="megamenu" class="megamenu">
    <div class="list-area" style="height: 350px">
        <a href="#">{{ l('همه آگهی ها') }}</a>
        <a id="landadsbtn">{{ l('املاک') }}</a>
        <a href="#">{{ l('وسایل نقلیه') }}</a>
        <a href="#">{{ l('لوازم الکترونیکی') }}</a>
        <a href="#">{{ l('مربوط به خانه') }}</a>
        <a href="#">{{ l('خدمات') }}</a>
    </div>
    <div class="list-child row d-none" id="landadsarea">
        <div class="col-lg-6 py-3">
            <a href="#"><b>{{ l('فروش مسکونی') }}</b></a>
            <ul>
                <li><a href="#">{{ l('آپارتمان') }}</a></li>
                <li><a href="#">{{ l('خانه و ویلا') }}</a></li>
                <li><a href="#">{{ l('زمین کلنگی') }}</a></li>
                <li><a href="#">{{ l('همه آگهی های فروش مسکونی') }}</a></li>
            </ul>
            <a href="#"><b>{{ l('فروش مسکونی') }}</b></a>
            <ul>
                <li><a href="#">{{ l('آپارتمان') }}</a></li>
                <li><a href="#">{{ l('خانه و ویلا') }}</a></li>
                <li><a href="#">{{ l('زمین کلنگی') }}</a></li>
                <li><a href="#">{{ l('همه آگهی های فروش مسکونی') }}</a></li>
            </ul>
        </div>
        <div class="col-lg-6 py-3">
            <a href="#"><b>{{ l('فروش مسکونی') }}</b></a>
            <ul>
                <li><a href="#">{{ l('آپارتمان') }}</a></li>
                <li><a href="#">{{ l('خانه و ویلا') }}</a></li>
                <li><a href="#">{{ l('زمین کلنگی') }}</a></li>
                <li><a href="#">{{ l('همه آگهی های فروش مسکونی') }}</a></li>
            </ul>

            <a href="#"><b>{{ l('فروش مسکونی') }}</b></a>
            <ul>
                <li><a href="#">{{ l('آپارتمان') }}</a></li>
                <li><a href="#">{{ l('خانه و ویلا') }}</a></li>
                <li><a href="#">{{ l('زمین کلنگی') }}</a></li>
                <li><a href="#">{{ l('همه آگهی های فروش مسکونی') }}</a></li>
            </ul>
        </div>
    </div>
</div>
<script>
    function megaMenu() {
        document.getElementById("megamenu").classList.toggle("d-block");
    }
    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("megamenu");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('d-block')) {
                    openDropdown.classList.remove('d-block');
                }
            }
        }
    }



    window.onmouseover = function(event) {
        if (!event.target.matches('#landadsbtn')) {
            $('#landadsarea').addClass("d-none");
            $('.megamenu').css("width", "auto");

        }
    }
    window.onmouseout = function(event) {
        if (!event.target.matches('#landadsbtn')) {
            $('#landadsarea').removeClass("d-none");
            $('.megamenu').css("width", "100%");

        }

    }
</script>
