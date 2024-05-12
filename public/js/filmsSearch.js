import { fetchFilms } from './fetchFilms.js'

let filterRated = false

const searchSection = document.querySelector('.search--desktop')
const ratedBtn = searchSection.querySelector('.search__rated-btn');
const loggedInInput = searchSection.querySelector('#isLoggedIn');

const search = document.querySelector('#search');
const searchSubmitBtn = document.querySelector('.search__form__submit');


ratedBtn.addEventListener('click', async () => {
    const isLoggedIn = loggedInInput.value;

    if (!isLoggedIn) {
        alert("You must be logged in to show only films rated by you");

        return;
    }

    filterRated = !filterRated;

    const ratedBtnInner = ratedBtn.querySelector('span');
    ratedBtnInner.innerText = filterRated ? 'star_half' : 'star'

    await fetchFilms(filterRated);
})

search.addEventListener('keyup', async (event) => {
    if (event.key !== "Enter") {
        return;
    }

    event.preventDefault();

    await fetchFilms();
})

searchSubmitBtn.addEventListener('click', (event) =>
    fetchFilms()
);
