/*
 * Template
 * Authors --- Custom by Binh Nguyen ---
 */
(function ($) {
    // var sUrlRoot = document.getElementById("urlRoot").value;
    // var id = $('#jform_hotel_id').children("option:selected").data('id');

    var sAdult = "người lớn"; // document.getElementById("adult").value;
    var sAdults = "người lớn"; // document.getElementById("adults").value;

    var sChild = "trẻ em"; //document.getElementById("child").value;
    var sChildren = "trẻ em"// document.getElementById("children").value;

    var sInfant = "em bé";

    const guestBtn = document.querySelector("#airticket #contact_guests"),
            guestOptions = document.querySelector("#airticket #guests-input-options"),
            adultsSubsBtn = document.querySelector("#airticket #adults-subs-btn"),
            adultsAddBtn = document.querySelector("#airticket #adults-add-btn"),
            childrenSubsBtn = document.querySelector("#airticket #children-subs-btn"),
            childrenAddBtn = document.querySelector("#airticket #children-add-btn"),
            infantSubsBtn = document.querySelector("#airticket #infant-subs-btn"),
            infantAddBtn = document.querySelector("#airticket #infant-add-btn"),
            adultsCountEl = document.querySelector("#airticket #guests-count-adults"),
            childrenCountEl = document.querySelector("#airticket #guests-count-children"),
            infantCountEl = document.querySelector("#airticket #guests-count-infant");

    let maxNumGuests = 30,
            maxAdults = 10,
            maxChildren = 10,
            maxInfant = 10,
            adultsCount = 2,
            childrenCount = 1,
            infantCount = 1,
            isGuestInputOpen = false;

    updateValues();

    adultsAddBtn.addEventListener('click', function (e) {
        adultsCount = addValues(adultsCount);
        updateValues();
        e.stopPropagation();
    });
    adultsSubsBtn.addEventListener('click', function (e) {
        adultsCount = substractValues(adultsCount, 1);
        updateValues();
        e.stopPropagation();
    });

    childrenAddBtn.addEventListener('click', function (e) {
        childrenCount = addValues(childrenCount);
        updateValues();
        e.stopPropagation();
    });
    childrenSubsBtn.addEventListener('click', function (e) {
        childrenCount = substractValues(childrenCount, 0);
        updateValues();
        e.stopPropagation();
    });

    infantAddBtn.addEventListener('click', function (e) {
        infantCount = addValues(infantCount);
        updateValues();
        e.stopPropagation();
    });
    infantSubsBtn.addEventListener('click', function (e) {
        infantCount = substractValues(infantCount, 0);
        updateValues();
        e.stopPropagation();
    });

    function calcTotalGuests() {
        return adultsCount + childrenCount + infantCount;
    }

    function addValues(count) {
        return (calcTotalGuests() < maxNumGuests) ? count + 1 : count;
    }

    function substractValues(count, min) {
        return (count > min) ? count - 1 : count;
    }

    function updateValues() {
        let btnText = (adultsCount > 1) ? `${adultsCount} ${sAdults}` : `${adultsCount} ${sAdult}`;
        btnText += (childrenCount > 1) ? `, ${childrenCount} ${sChildren}` : `, ${childrenCount} ${sChild}`;
        btnText += (infantCount > 1) ? `, ${infantCount} ${sInfant}` : `, ${infantCount} ${sInfant}`;



        adultsCountEl.innerHTML = adultsCount;

        childrenCountEl.innerHTML = childrenCount;

        infantCountEl.innerHTML = infantCount;

        guestBtn.innerHTML = '\
            <div class="input-group">\n\
                <div class="input-group-prepend">\n\
                    <span class="input-group-text pl-0 background-none border-0"><img src="./images/icon/ic_people.svg"  alt="khách"></span>\n\
                </div>\n\
                <div class="filter-option">\n\
                    <div class="total-count">' + calcTotalGuests() + ' khách</div>\n\
                    <div class="total-guests">' + btnText + '</div>\n\
                </div>\n\
            </div>';

        $('#airticket input[name="adults"]').val(adultsCount);

        $('#airticket input[name="children"]').val(childrenCount);

        $('#airticket input[name="infant"]').val(infantCount);

        if (adultsCount === 1) {
            adultsSubsBtn.classList.add("disabled");
        } else {
            adultsSubsBtn.classList.remove("disabled");
        }

        if (childrenCount === 0) {
            childrenSubsBtn.classList.add("disabled");
        } else {
            childrenSubsBtn.classList.remove("disabled");
        }

        if (infantCount === 0) {
            infantSubsBtn.classList.add("disabled");
        } else {
            infantSubsBtn.classList.remove("disabled");
        }

        if (calcTotalGuests() === maxNumGuests) {
            adultsAddBtn.classList.add("disabled");

            childrenAddBtn.classList.add("disabled");

            infantAddBtn.classList.add("disabled");
        } else {
            adultsAddBtn.classList.remove("disabled");

            childrenAddBtn.classList.remove("disabled");

            infantAddBtn.classList.remove("disabled");
        }

        if (adultsCount === maxAdults) {
            adultsAddBtn.classList.add("disabled");
        } else {
            adultsAddBtn.classList.remove("disabled");
        }

        if (childrenCount === maxChildren) {
            childrenAddBtn.classList.add("disabled");
        } else {
            childrenAddBtn.classList.remove("disabled");
        }

        if (infantCount === maxInfant) {
            infantAddBtn.classList.add("disabled");
        } else {
            infantAddBtn.classList.remove("disabled");
        }
    }
    /*
     $('#jform_hotel_id').change(function () {
     id = $('#jform_hotel_id').children("option:selected").data('id');
     if (id) {
     $.ajax({
     url: sUrlRoot,
     type: "POST",
     data: {id: id, option: 'com_vic', task: 'searchbar.getData'},
     dataType: "json",
     beforeSend: function () {
     // $(".loading-progress").addClass("not-allowed");
     },
     success: function (result) {
     maxAdults = parseInt(result.adults_per_room);
     maxChildren = parseInt(result.children_per_room);
     maxNumGuests = maxAdults + maxChildren;
     },
     error: function (result) {
     console.log(result);
     }
     }).done(function () {
     if (adultsCount > maxAdults) {
     adultsCount = maxAdults;
     }
     if (childrenCount > maxChildren) {
     childrenCount = maxChildren;
     }
     updateValues();
     });
     } else { // id: undefined
     maxNumGuests = 20;
     maxAdults = 10;
     maxChildren = 10;
     adultsCount = 1;
     childrenCount = 0;
     isGuestInputOpen = false;
     
     updateValues();
     }
     });
     */
})(jQuery);