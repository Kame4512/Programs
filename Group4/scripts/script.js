function showDownloadLink(fileName) {
    // Show the download link when the PDF fails to load in the iframe
    document.getElementById('download-link-' + fileName.split('.')[0]).style.display = 'block';
}


let slideIndex = 0;
const slideData = [
    "Origins and Early Development: Reggae music emerged in Jamaica in the late 1960s, evolving from earlier genres like ska and rocksteady. Ska, heavily influenced by American R&B and jazz, was characterized by its fast tempo and prominent horn sections. By the mid-1960s, ska slowed to form rocksteady, emphasizing soulful vocals and heavy basslines. As rocksteady gave way to reggae, the genre developed its signature “one-drop” rhythm, where the emphasis falls on the third beat of the measure, creating its distinctive offbeat sound.",
    "Cultural and Social Influences: Reggae’s rise was deeply intertwined with Jamaica’s social and political landscape, especially in the post-independence era after 1962. The genre became a voice for the oppressed, addressing inequality, resistance, and liberation themes. Rastafarianism, a spiritual movement rooted in African identity and resistance to colonialism, was crucial in shaping reggae’s lyrical content. Its themes of unity, peace, and spirituality became hallmarks of reggae, and many artists adopted Rastafarian beliefs, incorporating them into their music.",
    "Global Breakthrough and Iconic Artists: In the early 1970s, reggae began to gain international attention, primarily due to the influence of Bob Marley and The Wailers. Marley’s music, with its messages of love, justice, and freedom, resonated worldwide, making him the most iconic figure in reggae history. Other influential artists like Peter Tosh and Jimmy Cliff also played key roles in bringing reggae to global audiences. Jimmy Cliff’s starring role in the 1972 film The Harder They Come was pivotal in introducing the genre to new listeners and solidifying reggae’s place on the world stage.",
    "Information about Slide 2.",
    "Legacy and Cultural Impact: Reggae has left an indelible mark on global music and culture. In 2018, UNESCO recognized reggae as an Intangible Cultural Heritage of Humanity, acknowledging its contributions to international culture and its role as a voice for the marginalized. Reggae’s themes of peace, resistance, and cultural pride continue to resonate, and its influence can be seen in genres worldwide. From Bob Marley’s enduring legacy to the continued innovation within the genre, reggae remains a powerful force in music and cultural expression."
];

function showSlide(n) {
    const slides = document.querySelectorAll('.slides');
    if (n >= slides.length) slideIndex = 0;
    if (n < 0) slideIndex = slides.length - 1;
    slides.forEach(slide => slide.style.display = 'none');
    slides[slideIndex].style.display = 'block';
}

function changeSlide(n) {
    slideIndex += n;
    showSlide(slideIndex);
}

function showPopup(index) {
    const popup = document.getElementById('popup');
    const popupContent = document.getElementById('popup-content');
    popupContent.textContent = slideData[index];
    popup.style.display = 'block';
}

/*function closePopup() {
    document.getElementById('popup').style.display = 'none';
}*/

// Initialize the slideshow
showSlide(slideIndex);


function openAndDownload(url) {
    // Open the PDF in a new tab
    const newTab = window.open(url, '_blank');

    // Check if the new tab was successfully opened
    if (newTab) {
        // Start the download in the new tab
        newTab.location.href = url;
    } else {
        alert('The new tab was blocked. Please allow pop-ups for this site.');
    }
}

// Function to show the popup with the meaning of the selected color
function showColorMeaning(event, color, meaning) {
    // Prevent the default behavior of the area tag (i.e., page jump)
    event.preventDefault();

    const popup = document.getElementById('popup');
    const colorName = document.getElementById('color-name');
    const colorMeaning = document.getElementById('color-meaning');

    colorName.textContent = color;
    colorMeaning.textContent = meaning;

    popup.style.display = 'block';
}

// Function to close the popup
function closePopup() {
    document.getElementById('popup').style.display = 'none';
}

