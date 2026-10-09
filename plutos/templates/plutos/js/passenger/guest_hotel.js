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

    var sRoom = "phòng";

    const guestBtn = document.querySelector("#hotel #hotel_guests"),
            guestOptions = document.querySelector("#hotel #hotel_guests-input-options"),
            adultsSubsBtn = document.querySelector("#hotel #hotel_adults-subs-btn"),
            adultsAddBtn = document.querySelector("#hotel #hotel_adults-add-btn"),
            childrenSubsBtn = document.querySelector("#hotel #hotel_children-subs-btn"),
            childrenAddBtn = document.querySelector("#hotel #hotel_children-add-btn"),
            roomSubsBtn = document.querySelector("#hotel #hotel_room-subs-btn"),
            roomAddBtn = document.querySelector("#hotel #hotel_room-add-btn"),
            adultsCountEl = document.querySelector("#hotel #hotel_guests-count-adults"),
            childrenCountEl = document.querySelector("#hotel #hotel_guests-count-children"),
            roomCountEl = document.querySelector("#hotel #hotel_guests-count-room");

    let maxNumGuests = 30,
            maxAdults = 10,
            maxChildren = 10,
            maxInfant = 10,
            adultsCount = 2,
            childrenCount = 1,
            roomCount = 1,
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

    roomAddBtn.addEventListener('click', function (e) {
        roomCount = addValues(roomCount);
        updateValues();
        e.stopPropagation();
    });
    roomSubsBtn.addEventListener('click', function (e) {
        roomCount = substractValues(roomCount, 0);
        updateValues();
        e.stopPropagation();
    });

    function calcTotalGuests() {
        return adultsCount + childrenCount + roomCount;
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

        adultsCountEl.innerHTML = adultsCount;

        childrenCountEl.innerHTML = childrenCount;

        roomCountEl.innerHTML = roomCount;

        guestBtn.innerHTML = '\
            <div class="input-group">\n\
                <div class="input-group-prepend">\n\
                    <span class="input-group-text pl-0 background-none border-0"><img src="./images/icon/ic_people.svg"  alt="khách"></span>\n\
                </div>\n\
                <div class="filter-option">\n\
                    <div class="total-hotel-guests">' + btnText + '</div>\n\
                    <div class="total-room using-text-secondary-light">' + roomCount + ' ' + sRoom+ '</div>\n\
                </div>\n\
            </div>';

        $('#hotel input[name="adults"]').val(adultsCount);

        $('#hotel input[name="children"]').val(childrenCount);

        $('#hotel input[name="rooms"]').val(roomCount);

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

        if (roomCount === 0) {
            roomSubsBtn.classList.add("disabled");
        } else {
            roomSubsBtn.classList.remove("disabled");
        }

        if (calcTotalGuests() === maxNumGuests) {
            adultsAddBtn.classList.add("disabled");

            childrenAddBtn.classList.add("disabled");

            roomAddBtn.classList.add("disabled");
        } else {
            adultsAddBtn.classList.remove("disabled");

            childrenAddBtn.classList.remove("disabled");

            roomAddBtn.classList.remove("disabled");
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

        if (roomCount === maxInfant) {
            roomAddBtn.classList.add("disabled");
        } else {
            roomAddBtn.classList.remove("disabled");
        }
    }
})(jQuery);