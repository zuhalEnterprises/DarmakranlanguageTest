
function Paging(PageNumber, PageSize, TotalRecords, ClassName, DisableClassName) {

    if(TotalRecords>0){
                var ReturnValue = "<ul class=\"pagination mb-1\">";


                var TotalPages = Math.ceil(TotalRecords / PageSize);
                console.log(parseInt(TotalRecords));


                if (+PageNumber > 1) {

                    if (+PageNumber == 2){

                        ReturnValue = ReturnValue + "<li class=\"page-item ssdsa\"><a pn='" + (+PageNumber - 1) + "' class='page-link border-1 border-dark rounded-1 px-3 py-2 cursor-pointer bg-secondary'><i class=\"fs-base fw-normal fa-thin fa-angle-left\"></i></a></li>";
                    }
                        else {

                        ReturnValue = ReturnValue + "<li class=\"page-item rrr\"><a pn='";
                        ReturnValue = ReturnValue + (+PageNumber - 1) + "'  class='page-link border-1 border-dark rounded-1 px-3 py-2 cursor-pointer bg-secondary'><i class=\"fs-base fw-normal fa-thin fa-angle-left\"></i></a></li>";
                    }
                }
                else{

                  // ReturnValue = ReturnValue + "<li class=\"page-item llll\"><a class=\"page-link border-1 border-dark rounded-1 px-3 py-2 bg-secondary cursor-pointer\"><i class=\"fs-base fw-normal fa-thin fa-angle-right\"></i></a></li>";

                }
                if ((PageNumber - 3) > 0)
                    ReturnValue = ReturnValue + "<li class=\"page-item  kkk\"><a pn='1'  class='page-link border-1 border-dark rounded-1 px-3 py-2 cursor-pointer'>1</a></li>&nbsp;.....&nbsp;";
                else if(TotalPages>3)
                    {

                        if(PageNumber>2){
                        ReturnValue = ReturnValue + "<li class=\"page-item\"><a pn='1'  class='page-link page-link border-1 border-dark rounded-1 px-3 py-2 cursor-pointer'>1</a></li>";
                        }
                    }



                    for (var i =(TotalPages-PageNumber<=1)?(TotalPages-2):(+PageNumber - 1); i <=((PageNumber==1 || PageNumber==2)?(parseInt(TotalPages)>3?3:(parseInt(TotalPages)<=3?TotalPages:parseInt(PageNumber)+parseInt(1))):PageNumber); i++){
                    if (i >= 1) {

                        if (+PageNumber == i) {

                            ReturnValue = ReturnValue + "<li class=\"page-item\"><a pn='";
                            ReturnValue = ReturnValue + i + "'  class='page-link checkepagination bg-primary border-1 border-dark rounded-1 px-3 py-2 cursor-pointer text-white'>" + i + "</a></li>";
                        }
                        else {

                            ReturnValue = ReturnValue + "<li class=\"page-item\"><a pn='"+i+"' class=' page-link border-1 border-dark rounded-1 px-3 py-2 cursor-pointer' >"+ i + "</a></li>";
                        }
                    }
                }

                for (var i =(parseInt(PageNumber)<=3)?(parseInt(TotalPages)>3?4:parseInt(PageNumber) +parseInt(2)):((parseInt(TotalPages)-parseInt(PageNumber)<3)?parseInt(PageNumber)+1:(parseInt(PageNumber)+1)); i <= parseInt(PageNumber) +parseInt(1); i++){

                    if (i <= TotalPages) {

                        if (+PageNumber != i) {

                            ReturnValue = ReturnValue + "<li class=\"page-item\"><a pn='";
                            ReturnValue = ReturnValue + i + "'  class='page-link border-1 border-dark rounded-1 px-3 py-2 cursor-pointer'>" + i + "</a></li>";
                        }
                        else {
                            ReturnValue = ReturnValue + "<li class=\"page-item\"><a pn='"+i+"' class='page-link border-1 border-dark rounded-1 px-3 py-2 cursor-pointer' >"+ i + "</a></li>";
                        }
                    }
                }

                    if (parseInt(parseInt(PageNumber) + parseInt(3)) <= TotalPages) {

                        ReturnValue = ReturnValue + ".....&nbsp;<li class=\"page-item\"><a pn='";
                        ReturnValue = ReturnValue + TotalPages + "'  class='page-link border-1 border-dark rounded-1 px-3 py-2 cursor-pointer'>" + TotalPages + "</a></li>";
                    }
                    else
                    {
                        if(TotalPages>3){
                        if(parseInt(TotalPages)-parseInt(PageNumber)>1){
                        ReturnValue = ReturnValue + "<li class=\"page-item\"><a pn='";
                        ReturnValue = ReturnValue + TotalPages + "'  class='page-link border-1 border-dark rounded-1 px-3 py-2 cursor-pointer'>" + TotalPages + "</a></li>";}
                        }
                    }

                    if (+PageNumber < TotalPages) {
                        ReturnValue = ReturnValue + "<li class=\"page-item\"><a pn='";
                        ReturnValue = ReturnValue + (+PageNumber + 1) + "'  class='border-1 border-dark cursor-pointer page-link px-3 py-2 rounded-1 bg-secondary'><i class=\"fs-base fw-normal fa-thin fa-angle-right\"></i></a><li>";
                    }
                    else
                    {
                        //ReturnValue = ReturnValue + "<li class=\"page-item\"><a class='border-1 border-dark cursor-pointer page-link px-3 py-2 rounded-1 bg-secondary'><i class=\"fs-base fw-normal fa-thin fa-angle-left\"></i></a></li>";
                    }

                    ReturnValue=ReturnValue +"</ul>";

                return (ReturnValue);
            }
            else return ''
            }
