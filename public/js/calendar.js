(function($) {

	"use strict";

	$( document ).ready(function() {
		document.getElementById("rdv_Sauvegarder").addEventListener("click", function(){

				if(document.getElementById("rdv_date").value === "") {
					document.getElementById("errorMessage").style.display = "inherit";
				}

		})
		var currentDate =null;
		if (document.getElementById("rdv_date").value !== "") {
			currentDate = document.getElementById("rdv_date").value;
		}
		document.getElementById("coachName").innerHTML = document.getElementById("rdv_idCoach").options[document.getElementById("rdv_idCoach").selectedIndex].text;
		document.getElementById("rdv_idCoach").addEventListener("change", function() {
			$.post("/refreshCalendar/"+document.getElementById("rdv_idCoach").value, function(data) {
				document.getElementById("coachName").innerHTML = document.getElementById("rdv_idCoach").options[document.getElementById("rdv_idCoach").selectedIndex].text;
				reservedDates = data;
				try {
					checkedDates.forEach(function (item) {
						item.removeClass("busy-date");
					})
					checkedDatesLength = 0;
				} finally {

					if (reservedDates.length >0) {
						c(month, year, 0);
						c(nextMonth, nextYear, 1);
					}
				}
			})
		})
		function c(passed_month, passed_year, calNum) {
			calendar = calNum == 0 ? calendars.cal1 : calendars.cal2;
			makeWeek(calendar.weekline);
			calendar.datesBody.empty();
			var calMonthArray = makeMonthArray(passed_month, passed_year);
			var r = 0;
			var u = false;
			while(!u) {
				if(daysArray[r] == calMonthArray[0].weekday) { u = true }
				else {
					calendar.datesBody.append('<div class="blank"></div>');
					r++;
				}
			}
			for(var cell=0;cell<42-r;cell++) { // 42 date-cells in calendar
				if(cell >= calMonthArray.length) {
					calendar.datesBody.append('<div class="blank"></div>');
				} else {
					var shownDate = calMonthArray[cell].day;
					// Later refactiroing -- iter_date not needed after "today" is found
					var iter_date = new Date(passed_year,passed_month,shownDate);

					if (
						(
							( shownDate != today.getDate() && passed_month == today.getMonth() )
							|| passed_month != today.getMonth()
						)
							&& iter_date < today) {
						var m = '<div class="past-date">';
					} else{
						var m = checkToday(iter_date)?'<div class="today">':"<div>";
					}
					calendar.datesBody.append(m + shownDate + "</div>");
				}
			}

			// var color = o[passed_month];
			calendar.calHeader.find("h2").text(i[passed_month]+" "+passed_year);
						//.css("background-color",color)
						//.find("h2").text(i[passed_month]+" "+year);

			// find elements (dates) to be clicked on each time
			// the calendar is generated

			//clickedElement = bothCals.find(".calendar_content").find("div");
			var clicked = false;

			clickedElement = calendar.datesBody.find('div');
			clickedElement.on("click", function(){


				if ($(this).hasClass('past-date') || $(this).hasClass('busy-date') || $(this).hasClass('blank')) { return; }

				bothCals.find(".calendar_content").find("div").each(function(){
					$(this).removeClass("selected");
				});
				clicked = $(this);
				firstClicked = getClickedInfo(clicked, calendar);

					selectedDate = new Date(firstClicked.year,
						firstClicked.month,
						(firstClicked.date));
				clicked.addClass("selected");


				let ye = new Intl.DateTimeFormat('en', {year: 'numeric'}).format(selectedDate);
				let mo = new Intl.DateTimeFormat('en', {month: '2-digit'}).format(selectedDate);
				let da = new Intl.DateTimeFormat('en', {day: '2-digit'}).format(selectedDate);
				selectedDate = `${da}/${mo}/${ye}`;
				document.getElementById("rdv_date").value =selectedDate;
				document.getElementById("errorMessage").style.display = "none";

			});
			if (reservedDates.length >0) {
				setCheckedDates();
			}
		}
		function setCheckedDates() {
			bothCals.find(".calendar_content").find("div").each(function(){
				if ($(this).hasClass('today') || $(this).hasClass('past-date') || $(this).hasClass('busy-date') || $(this).hasClass('blank')) { return; }
				else {
					let sel = $(this);
					testSelection = getClickedInfo(sel, calendar)
					var testDate = new Date(testSelection.year,
						testSelection.month,
						(testSelection.date));
					try {
						let ye = new Intl.DateTimeFormat('en', {year: 'numeric'}).format(testDate);
						let mo = new Intl.DateTimeFormat('en', {month: '2-digit'}).format(testDate);
						let da = new Intl.DateTimeFormat('en', {day: '2-digit'}).format(testDate);
						let date = `${da}/${mo}/${ye}`;
						reservedDates.forEach(function (dt) {
							if (date === dt) {
								checkedDates[checkedDatesLength] = sel;
								checkedDatesLength++;
								sel.addClass("busy-date");
							}
						})


					} catch (e) {
						console.log(e);
					}
				}
			});

		}
		function makeMonthArray(passed_month, passed_year) { // creates Array specifying dates and weekdays
			var e=[];
			for(var r=1;r<getDaysInMonth(passed_year, passed_month)+1;r++) {
				e.push({day: r,
						// Later refactor -- weekday needed only for first week
						weekday: daysArray[getWeekdayNum(passed_year,passed_month,r)]
					});
			}
			return e;
		}
		function makeWeek(week) {
			week.empty();
			for(var e=0;e<7;e++) {
				week.append("<div>"+daysArray[e].substring(0,3)+"</div>")
			}
		}

		function getDaysInMonth(currentYear,currentMon) {
			return(new Date(currentYear,currentMon+1,0)).getDate();
		}
		function getWeekdayNum(e,t,n) {
			return(new Date(e,t,n)).getDay();
		}
		function checkToday(e) {
			let ye = new Intl.DateTimeFormat('en', {year: 'numeric'}).format(e);
			let mo = new Intl.DateTimeFormat('en', {month: '2-digit'}).format(e);
			let da = new Intl.DateTimeFormat('en', {day: '2-digit'}).format(e);
			let date = `${da}/${mo}/${ye}`;
			return currentDate==date;

		}
		function getAdjacentMonth(curr_month, curr_year, direction) {
			var theNextMonth;
			var theNextYear;
			if (direction == "next") {
				theNextMonth = (curr_month + 1) % 12;
				theNextYear = (curr_month == 11) ? curr_year + 1 : curr_year;
			} else {
				theNextMonth = (curr_month == 0) ? 11 : curr_month - 1;
				theNextYear = (curr_month == 0) ? curr_year - 1 : curr_year;
			}
			return [theNextMonth, theNextYear];
		}
		function b() {
			today = new Date;
			year = today.getFullYear();
			month = today.getMonth();
			var nextDates = getAdjacentMonth(month, year, "next");
			nextMonth = nextDates[0];
			nextYear = nextDates[1];
		}

		var e=480;

		var today;
		var year,
			month,
			nextMonth,
			nextYear;

		//var t=2013;
		//var n=9;
		var r = [];
		var i = ["January","February","March","April","May",
				"June","July","August","September","October",
				"November","December"];
		var daysArray = ["Sunday","Monday","Tuesday",
						"Wednesday","Thursday","Friday","Saturday"];
		var o = ["#16a085","#1abc9c","#c0392b","#27ae60",
				"#FF6860","#f39c12","#f1c40f","#e67e22",
				"#2ecc71","#e74c3c","#d35400","#2c3e50"];

		var cal1=$("#calendar_first");
		var calHeader1=cal1.find(".calendar_header");
		var weekline1=cal1.find(".calendar_weekdays");
		var datesBody1=cal1.find(".calendar_content");

		var cal2=$("#calendar_second");
		var calHeader2=cal2.find(".calendar_header");
		var weekline2=cal2.find(".calendar_weekdays");
		var datesBody2=cal2.find(".calendar_content");

		var bothCals = $(".calendar");

		var switchButton = bothCals.find(".calendar_header").find('.switch-month');

		var calendars = {
						"cal1": { 	"name": "first",
									"calHeader": calHeader1,
									"weekline": weekline1,
									"datesBody": datesBody1 },
						"cal2": { 	"name": "second",
									"calHeader": calHeader2,
									"weekline": weekline2,
									"datesBody": datesBody2	}
						}


		var clickedElement;
		var calendar;
		var firstClicked;
		var testSelection;
		var selected = {};
		var selectedDate = currentDate;
		var checkedDates = [];
		var checkedDatesLength = 0;

		b();
		c(month, year, 0);
		c(nextMonth, nextYear, 1);
		switchButton.on("click",function() {
			var clicked=$(this);
			var generateCalendars = function(e) {
				var nextDatesFirst = getAdjacentMonth(month, year, e);
				var nextDatesSecond = getAdjacentMonth(nextMonth, nextYear, e);
				month = nextDatesFirst[0];
				year = nextDatesFirst[1];
				nextMonth = nextDatesSecond[0];
				nextYear = nextDatesSecond[1];

				c(month, year, 0);
				c(nextMonth, nextYear, 1);
			};
			if(clicked.attr("class").indexOf("left")!=-1) {
				generateCalendars("previous");
			} else { generateCalendars("next"); }
			clickedElement = bothCals.find(".calendar_content").find("div");
			console.log("checking");
		});


		//  Click picking stuff
		function getClickedInfo(element, calendar) {
			var clickedInfo = {};
			var clickedCalendar,
				clickedMonth,
				clickedYear;
			clickedCalendar = calendar.name;
			//console.log(element.parent().parent().attr('class'));
			clickedMonth = clickedCalendar == "first" ? month : nextMonth;
			clickedYear = clickedCalendar == "first" ? year : nextYear;
			clickedInfo = {"calNum": clickedCalendar,
							"date": parseInt(element.text()),
							"month": clickedMonth,
							"year": clickedYear}
			//console.log(clickedInfo);
			return clickedInfo;
		}
});
})(jQuery);
