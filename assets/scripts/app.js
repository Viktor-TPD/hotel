console.log("Javascript connected!");

// MAKE DAYS CLICKABLE ON CALENDAR
const days = document.getElementsByClassName("day");
const selectedDaysContainer = document.getElementById("selectedDatesContainer");
let selectedDaysArray = [];

// FOR THE PRICES LATER
const priceDisplay = document.getElementById("totalPrice");
// document.querySelector(".flexRow:last-child").appendChild(priceDisplay);

// THIS ALLOWS NUMBERS TO BE SORTED NOT IN "ALPHABETICAL" ORDER i.e.: [1,10,100,2,200,3]
// BUT IN NUMERICAL ORDER i.e.: [1,2,3,10,100,200]
function compareNumbers(a, b) {
  return a - b;
}

// FETCH PRICES FROM THE DATABASE
let prices = {}; // Declare prices globally

fetch("./app/posts/get-room-prices.php")
  .then((response) => response.json())
  .then((data) => {
    console.log("Price data:", data); // Debug Point 1
    prices = data.reduce(
      (acc, room) => ({
        ...acc,
        [room.type]: room.price,
      }),
      {}
    );
    console.log("Processed prices:", prices); // Debug Point 2
  })
  .catch((error) => console.error("Fetch error:", error));

// ADD CLICK EVENT LISTENERS TO DAYS
for (let i of days) {
  i.addEventListener("mouseup", () => {
    if (!i.classList.contains("booked")) {
      i.classList.toggle("calendar-selected");
      const child = i.firstElementChild;

      if (!selectedDaysArray.includes(child.textContent)) {
        // DAY IS SELECTED SO WE ADD IT
        selectedDaysArray.push(child.textContent);
      } else {
        // DAY IS PREVIOUSLY SELECTED, SO WE REMOVE IT
        selectedDaysArray.splice(
          selectedDaysArray.indexOf(child.textContent),
          1
        );
      }

      // SORT THE ARRAY
      selectedDaysArray.sort(compareNumbers);

      // UPDATE THE SELECTED DATES CONTAINER
      selectedDaysContainer.value = selectedDaysArray.join(", ");

      // UPDATE THE PRICE
      const roomType = document.getElementById("roomType").value;
      const totalPrice = selectedDaysArray.length * (prices[roomType] || 0);
      priceDisplay.textContent = `$${totalPrice}`;

      // DEBUGGING OUTPUT
      console.log("Selected Days:", selectedDaysArray);
      console.log("Room Type:", roomType);
      console.log("Total Price:", totalPrice);
    }
  });
}

// PARALLAX FOR BACKGROUND IMAGE
window.addEventListener("scroll", function () {
  const parallaxImage = document.getElementById("parallaxImage");
  let offset = window.scrollY;
  parallaxImage.style.top = offset * 0.3 + "px";
});
