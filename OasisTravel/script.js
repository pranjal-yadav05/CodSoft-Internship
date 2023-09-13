var logpop = document.getElementById("login-popup");
var regpop = document.getElementById("register-popup");

function openreg(){
    regpop.style.display="block";
}
function openlog(){
    logpop.style.display="block";
}
function closelog(){
    logpop.style.display="none";
}
function closereg(){
    regpop.style.display="none";
}


document.addEventListener("DOMContentLoaded", function () {
    const departureInput = document.getElementById("departure");
    const destinationInput = document.getElementById("destination");
    const departureSuggestionsBox = document.getElementById("departureSuggestions");
    const destinationSuggestionsBox = document.getElementById("destinationSuggestions");

    departureSuggestionsBox.addEventListener("click", function (event) {
        handleSuggestionClick(event.target, departureInput, departureSuggestionsBox);
    });

    destinationSuggestionsBox.addEventListener("click", function (event) {
        handleSuggestionClick(event.target, destinationInput, destinationSuggestionsBox);
    });

     
    departureInput.addEventListener("input", function () {
        const inputWidth = departureInput.offsetWidth;
        departureSuggestionsBox.style.width = inputWidth + "px";
      const inputValue = departureInput.value;
      if (inputValue.length >= 2) {
        fetchCitySuggestions(inputValue, departureSuggestionsBox, departureInput, destinationInput);
      } else {
        hideSuggestions(departureSuggestionsBox);
      }
    });

    departureInput.addEventListener("blur", function () {
        setTimeout(function () {
            hideSuggestions(departureSuggestionsBox);
        }, 300);
    });

    destinationInput.addEventListener("input", function () {
        const inputWidth = destinationInput.offsetWidth;
        destinationSuggestionsBox.style.width = inputWidth + "px";
      const inputValue = destinationInput.value;
      if (inputValue.length >= 2) {
        fetchCitySuggestions(inputValue, destinationSuggestionsBox, destinationInput, departureInput);
      } else {
        hideSuggestions(destinationSuggestionsBox);
      }
    });

    destinationInput.addEventListener("blur", function () {
        setTimeout(function () {
            hideSuggestions(destinationSuggestionsBox);
        }, 300);
    });
    function fetchCitySuggestions(inputValue, suggestionBox, inputElement, otherInputElement) {
        const excludedCity = otherInputElement.value;
        fetch("fetch_cities.php?input=" + inputValue + "&exclude=" + excludedCity)
            .then((response) => response.json())
            .then((data) => {
                displaySuggestions(data, suggestionBox, inputElement);
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
            });
    }

    function displaySuggestions(suggestions, suggestionBox, inputElement) {
        suggestionBox.innerHTML = ""; // Clear previous suggestions
        suggestions.forEach((city) => {
            const suggestionItem = document.createElement("div");
            suggestionItem.className = "suggestion";
            suggestionItem.textContent = city;
            suggestionItem.addEventListener("click", function () {
                console.log("Suggestion clicked:", city);
                fillSuggestion(city, inputElement);
                hideSuggestions(suggestionBox);
            });
            suggestionBox.appendChild(suggestionItem);
        });
        suggestionBox.style.display = "block";
        suggestionBox.style.position = "absolute"; 
        suggestionBox.style.left = inputElement.offsetLeft + "px"; 
        suggestionBox.style.top = inputElement.offsetTop + inputElement.offsetHeight + "px"; 
    }
    
    function fillSuggestion(city, inputElement) {
        console.log("Filling suggestion:", city);
        inputElement.value = city;
    }
    

    function hideSuggestions(suggestionBox) {
      suggestionBox.style.display = "none";
    }
});
