$(document).ready(function () {
    $(".select2").select2({
        language: "fa",
        placeholder: "انتخاب",
    });

    $("#js_add_options").on("click", function (e) {
        $(".remove_property").parent().remove();
        var variabel_single = $("#js_form_modal").find(":selected");
        var variabel_multiple = $("#js_form_modal").find(
            ".select2-selection__choice"
        );
        console.log(variabel_single.length);
        var variabel_text = [];

        for (let i = 0; i < variabel_single.length; i++) {
            const element = variabel_single[i];
            const nameElement = $(element).attr("title");
            const textElement = $(element).text();
            const fullName = nameElement + " " + textElement;
            if (nameElement !== undefined) {
                variabel_text.push(fullName);
            }
        }
        for (let i = 0; i < variabel_multiple.length; i++) {
            const element = variabel_multiple[i];
            const nameElement = $(element).attr("title");
            // const textElement = $(element).text()
            // const fullName = nameElement + ' ' + textElement;
            if (nameElement !== undefined) {
                variabel_text.push(nameElement);
            }
        }
        console.log(variabel_text);
        // console.log('full',variabel_full)
        for (let i = 0; i < variabel_text.length; i++) {
            const content = `
            <div class="text-gray-500 bg-white h-[48px] flex gap-1 items-center justify-center border border-blue-500 rounded-25 px-6  cursor-pointer">
                <span  class="remove_property"><i class="text-[24px] text-red-200 fa-thin fa-xmark"></i></span>
                <span type="" class="text-[16px] font-light">${variabel_text[i]}</span>
                <input type="hidden" value="${variabel_text[i]}" name="popup_[${i}]">
            </div>
        `;
            $("#js_property_box").append(content);
        }
    });

    // $(document).ready(function () {
    //     $(".remove_property").click(function () {
    //         console.log('sss')
    //     })
    // });
    $(document).on("click", ".remove_property", function () {
        $(this).parent().remove();
    });
    // ------------------------------

    $("#js_modal_proprty").on("click", function () {
        console.log("modal");
        $("#js_property_show").fadeIn("fast");
        $("body").css({ overflow: "hidden" });
    });
    $(".js_modal_close , #js_add_options").click(function (e) {
        e.preventDefault();
        $("#js_property_show").fadeOut("fast");
        $("body").css({ overflow: "auto" });
    });

    $("#js_form_add_state").validate({
        rules: {
            description: {
                required: true,
                minlength: 30,
                // maxlength: 300,
            },
            title: {
                required: true,
                minlength: 5,
                maxlength: 50,
            },
            commission_percent: {
                max:100,
                min:0
            }
        },
        errorPlacement: function (error, element) {
            var type = $(element).attr("cus-valid");
            if (type == "true") {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
    });

    var swiper = new Swiper(".js_filter_search", {
        slidesPerView: 3.4,
        spaceBetween: 16,
        freeMode: true,
        breakpoints: {
            350: {
                slidesPerView: 3.4,
            },
            767: {
                slidesPerView: "auto",
            },

        },
    });



    // Plus and Minus button
    $(".js_plus").on("click", function () {
        var inputValue = $(this).next().val();
        inputValue++;
        $(this).next().val(inputValue);
    });

    $(".js_input_form").on("keyup", function () {
        $(this).val(function (index, value) {
            return value.replace(/\D/g, "");
        });
    });
    $(".js_minus").on("click", function () {
        var inputValue = $(this).prev().val();
        if (inputValue > 1) {
            inputValue--;
            $(this).prev().val(inputValue);
        }
    });

    //  limit value for textarea and input
    // $(".js_input_max").on("keyup", function () {
    //     var maxLength = 50;
    //     var valueTextarea = $(this).val().length;
    //     $(this)
    //         .prev()
    //         .children()
    //         .last()
    //         .text(`${valueTextarea} از ${maxLength}`);
    //     if (maxLength > valueTextarea) {
    //         $(this).prev().children().last().addClass("text-gray-500");
    //         $(this).prev().children().last().removeClass("text-red-500");
    //     } else {
    //         $(this).prev().children().last().addClass("text-red-500");
    //         $(this).prev().children().last().removeClass("text-gray-500");
    //         $(this).attr("maxlength", maxLength);
    //     }
    // });
    //

    $("#js_price_state , .js_price_state").on("keyup", function () {
        var valueInput = $(this).val();
        var areaValue = $("#area").val();
        // console.log(areaValue)
        // convert nomber to letters
        var convertNumToLetters = valueInput.num2persian();
        $(this).parent().next().text(`${convertNumToLetters} تومان`);

        // number and add comma after three digit
        $(this).val(function (index, value) {
            return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        });

        // change to number
        var seprateComma = valueInput.split(",");
        var changeStrToNum = Number(seprateComma.join(""));

        var meters = (changeStrToNum / areaValue) / 1000000;
        // var roundMeters = Math.round(meters);
        if (areaValue != "") {
            if (meters >= 1) {
                $("#js_convert_meters").text(
                    `متری ${meters.toFixed(2)} میلیون تومان`
                );
            } else {
                $("#js_convert_meters").text("");
            }
        }
    });
    $(".js_just_number").on("keyup click change", function () {
        // console.log($(this).val())
        $(this).val(function (index, value) {
            return value.replace(/\D/g, "");
        });
    });
});
// audio recorder
/*
let recorder, audio_stream;
const recordButton = document.getElementById("recordButton");
recordButton.addEventListener("click", startRecording);

const stopButton = document.getElementById("stopButton");
stopButton.addEventListener("click", stopRecording);
stopButton.disabled = true;


const preview = document.getElementById("audio-playback");

const downloadAudio = document.getElementById("downloadButton");
downloadAudio.addEventListener("click", downloadRecording);

function startRecording(e) {
    e.preventDefault()

       recordButton.disabled = true;
       // recordButton.innerText = "Recording..."
       $("#recordButton").addClass("button-animate");

       $("#stopButton").removeClass("inactive");
       stopButton.disabled = false;

       if (!$("#audio-playback").hasClass("hidden")) {
           $("#audio-playback").addClass("hidden")
       };

       if (!$("#downloadContainer").hasClass("hidden")) {
           $("#downloadContainer").addClass("hidden")
       };

       navigator.mediaDevices.getUserMedia({ audio: true })
           .then(function (stream) {
               audio_stream = stream;
               recorder = new MediaRecorder(stream);
               recorder.ondataavailable = function (e) {
                   const url = URL.createObjectURL(e.data);
                   preview.src = url;

                   downloadAudio.href = url;
               };
               recorder.start();

               timeout_status = setTimeout(function () {
                   console.log("5 min timeout");
                   stopRecording();
               }, 300000);
           })
.catch(e => {
    alert('لطفاً دسترسی به میکروفن را در مرورگر فعال کنید');
})



}
*/
function stopRecording(e) {
    e.preventDefault();
    recorder.stop();
    audio_stream.getAudioTracks()[0].stop();

    // buttons reset
    recordButton.disabled = false;
    // recordButton.innerText = "Redo Recording"
    $("#recordButton").removeClass("button-animate");

    $("#stopButton").addClass("inactive");
    stopButton.disabled = true;

    $("#audio-playback").removeClass("hidden");

    $("#downloadContainer").removeClass("hidden");
}

function downloadRecording() {
    var name = new Date();
    var res = name.toISOString().slice(0, 10);
    downloadAudio.download = res + ".wav";
}


// Modal Choice expert

$('#search').keyup(function (e) {
    var searchValue = $(this).val()
    $('.cart-expert').filter(function () {
        $(this).toggle($(this).text().indexOf(searchValue) > -1);
    })
})

$('.selection').click(function () {
    $('.expert-selected-el').show()
    $('#selected').html('')
    var element_select = $(this).parent().parent();
    console.log(element_select.find('img').attr("src"))
    var img_select = element_select.find('img').attr("src")
    var name_select = element_select.find('.name-expert').html()
    var type_select = element_select.find('.type-expert').text()
    var experience_all = element_select.find('.experience_all').text()
    var experience_kama = element_select.find('.experience_kama').text()

    $('#selected').append(`
         <div
                class="cart-expert text-gray-200 px-6 py-3 bg-white rounded-2xl border border-gray-200 flex flex-col md:flex-row items-center gap-5 md:gap-0">
                <div class="w-full md:w-1/3 flex gap-2">
                    <div class="flex flex-col ">
                        <img src="${img_select}"
                            class="w-[50px] h-[50px] rounded-full overflow-hidden" alt="img">

                    </div>
                    <div class="flex flex-col gap-2">
                        <h3 class="text-gray-500 font-medium text-sm name-expert">
                            ${name_select}
                        </h3>
                        <p class="text-gray-500 font-light text-[12px]">
                            تخصص کارشناس: <span class="type-expert font-medium">${type_select}</span>
                        </p>
                    </div>
                </div>
                <div class="w-full md:w-1/3 flex flex-col gap-2">
                    <div class="text-gray-500 font-light text-sm">
                        سابقه فعالیت : <span class="experience_all font-medium">${experience_all}</span>
                    </div>
                    <div class="text-gray-500 font-light text-sm">
                        سابقه در میهن ملک : <span class="experience_kama font-medium"> ${experience_kama}</span>
                    </div>
                </div>
                <div class="w-full md:w-1/3">
                    <p
                        class="border border-gray-200 rounded-2xl h-[48px] flex items-center justify-center text-gray-500 font-medium text-sm md:w-1/2 mr-auto cursor-pointer bg-white selection_edit">
                        ویرایش
                    </p>
                </div>
         </div>
    `)
    $("#self").fadeOut('500')
    $('body').css({ overflow: "auto" })
})

$("#expert-self").click(function () {
    $("#self").fadeIn('500')
    $('body').css({ overflow: "hidden" })
    $('#expert_help').hide()
    $('.expert-selected-el').show()
})

$('#expert-kama').click(function () {
    $('#expert_help').show()
    $('.expert-selected-el').hide()
})

$(".js_modal_close").click(function (e) {
    e.preventDefault()
    $("#self").fadeOut('500')
    $('body').css({ overflow: "auto" })
})

$('#selected').on('click', '.selection_edit', function () {
    $("#self").fadeIn('500')
    $('body').css({ overflow: "hidden" })
})
