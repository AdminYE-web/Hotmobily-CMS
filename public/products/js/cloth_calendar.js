holidays = {
  0: {
    type1: [1],
    type2: [2, 3, 13],
    type3: [28, 29, 30],
  }, // January
  1: {
    type1: [],
    type2: [11, 23, 24],
    type3: [],
  }, // February
  2: {
    type1: [],
    type2: [20],
    type3: [],
  }, // March
  3: {
    type1: [],
    type2: [29],
    type3: [3, 4, 5],
  },
  4: {
    type1: [3, 4, 5],
    type2: [6, 7],
    type3: [1, 2, 25],
  }, // May
  5: {
    type1: [8],
    type2: [],
    type3: [3,9],
  }, // June
  6: {
    type1: [],
    type2: [21],
    type3: [],
  }, // July
  7: {
    type1: [1],
    type2: [11, 14, 15],
    type3: [2,3,4,5],
  }, // August
  8: {
    type1: [16],
    type2: [15, 23],
    type3: [15, 17],
  }, // September
  9: {
    type1: [],
    type2: [13],
    type3: [1, 2, 3, 4, 5, 6, 7, 8, 9],
  }, // October
  10: {
    type1: [],
    type2: [3, 23, 24],
    type3: [],
  }, // November
  11: {
    type1: [],
    type2: [31],
    type3: [],
  }, // December
};

now = new Date();
month = now.getMonth();
year = now.getFullYear();

numDays = new Date(year, month + 1, 0).getDate();
firstDay = new Date(year, month, 1).getDay();

tableBody = document
  .getElementById("calendar")
  .getElementsByTagName("tbody")[0];
tableBody.innerHTML = "";

nextMonth = month === 11 ? 0 : month + 1;
nextYear = month === 11 ? year + 1 : year;
nextNumDays = new Date(nextYear, nextMonth + 1, 0).getDate();
nextFirstDay = new Date(nextYear, nextMonth, 1).getDay();
monthTitle = `${month + 1}月 ${year}`;
document.getElementById("month").textContent = monthTitle;

monthHolidays = holidays[month];
nextMonthHolidays = holidays[nextMonth];

holidayType1 = [...monthHolidays.type1];
holidayType2 = [...monthHolidays.type2];
holidayType3 = [...monthHolidays.type3];
holidayType1_2 = [...nextMonthHolidays.type1];
holidayType2_2 = [...nextMonthHolidays.type2];
holidayType3_2 = [...nextMonthHolidays.type3];

date = 1;
for (i = 0; i < 6; i++) {
  row = document.createElement("tr");
  for (j = 0; j < 7; j++) {
    cell = document.createElement("td");

    if (i === 0 && j < firstDay) {
      row.appendChild(cell);
    } else if (date > numDays) {
      row.appendChild(cell);
    } else {
      cell.textContent;
      cell.textContent = date;
      row.appendChild(cell);

      dayOfWeek = j + 1;
      if (dayOfWeek === 7 || holidayType2.includes(date)) {
        cell.classList.add("holiday_type2");
      } else if (holidayType3.includes(date)) {
        cell.classList.add("holiday_type3");
      }
      if (dayOfWeek === 1 || holidayType1.includes(date)) {
        cell.classList.remove("holiday_type2");
        cell.classList.remove("holiday_type3");
        cell.classList.add("holiday_type1");
      }
      date++;
    }
  }
  if (row.innerHTML.trim() !== "") {
    tableBody.appendChild(row);
  }
}

nextMonthTitle = `${nextMonth + 1}月 ${nextYear}`;
nextMonthHeader = document.createElement("th");
nextMonthHeader.colSpan = "7";
nextMonthHeader.textContent = nextMonthTitle;
nextMonthHeader.classList.add("calendar_title");
nextMonthRow = document.createElement("tr");
nextMonthRow.appendChild(nextMonthHeader);
tableBody.appendChild(nextMonthRow);

nextDate = 1;
for (i = 0; i < 6; i++) {
  row = document.createElement("tr");
  if (i === 0) {
    for (j = 0; j < 7; j++) {
      cell = document.createElement("th");
      cell.textContent = days[j];
      row.appendChild(cell);
    }
    tableBody.appendChild(row);
  } else {
    for (j = 0; j < 7; j++) {
      cell = document.createElement("td");
      if (i === 1 && j < nextFirstDay) {
        row.appendChild(cell);
      } else if (nextDate > nextNumDays) {
        row.appendChild(cell);
      } else {
        cell.textContent = nextDate;
        row.appendChild(cell);

        dayOfWeek = j + 1;
        if (dayOfWeek === 7 || holidayType2_2.includes(nextDate)) {
          cell.classList.add("holiday_type2");
        } else if (holidayType3_2.includes(nextDate)) {
          cell.classList.add("holiday_type3");
        }
        if (dayOfWeek === 1 || holidayType1_2.includes(nextDate)) {
          cell.classList.remove("holiday_type2");
          cell.classList.remove("holiday_type3");
          cell.classList.add("holiday_type1");
        }
        nextDate++;
      }
    }
    if (row.innerHTML.trim() !== "") {
      tableBody.appendChild(row);
    }
  }
}
