console.log("Javascript connected!");

// MAKE DAYS CLICKABLE ON CALENDAR
const days = document.getElementsByClassName("day"); // @todo CHANGE THIS TO 'bookable' OR SIMILAR
const selectedDaysContainer = document.getElementById("showSelectedDates");
let selectedDaysArray = [];
// THIS ALLOWS NUMBERS TO BE SORTED NOT IN "ALPHABETICAL" ORDER [1,10,100,2,200,3] BUT IN "NUMBER" ORDER [1,2,3,10,100,200]
function compareNumbers(a, b) {
  return a - b;
}
for (let i of days) {
  i.addEventListener("mouseup", () => {
    // @todo OR MAYBE, AN IF (!BOOKED) OR SOMETHING
    i.classList.toggle("calendar-selected");
    const child = i.firstElementChild;
    console.log(child.textContent); //@debug

    if (selectedDaysArray.includes(child.textContent)) {
      //DAY IS PREVIOUSLY SELECTED, SO WE REMOVE IT
      selectedDaysArray.splice(selectedDaysArray.indexOf(child.textContent), 1);
    } else {
      //DAY IS SELECTED SO WE ADD IT
      selectedDaysArray.push(child.textContent);
    }
    //SORT THE ARRAY
    selectedDaysArray.sort();
    selectedDaysArray.sort(compareNumbers);
    //THEN PUSH CONTENT TO FIELD
    selectedDaysContainer.innerText = selectedDaysArray;
  });
}
