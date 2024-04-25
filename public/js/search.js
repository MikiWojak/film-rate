const search = document.querySelector('#search');
const filmsContainer = document.querySelector('.film_list');

search.addEventListener('keyup', async (event) => {
    if (event.key !== "Enter") {
        return;
    }

    event.preventDefault();

    const data = { search: event.target.value };

    try {
        const response = await fetch("/search", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(data),
        });

        const films = await response.json();

        filmsContainer.innerHTML = '';

        loadFilms(films);
    } catch (error) {
        console.error(error);
    }
})

const loadFilms = (films) => {
    films.forEach(film => {
        createFilm(film);
    })
}

const createFilm = (film) => {
    const template = document.querySelector('#film-template');
    const clone = template.content.cloneNode(true);

    const { title, posterUrl, avgRate } = film;

    const posterElement = clone.querySelector('img');
    posterElement.src = `public/uploads/${posterUrl}`;

    const titleElement = clone.querySelector('.film__title--inner');
    titleElement.innerHTML = title;

    const avgRateElement = clone.querySelector('.film__avg_rate--inner');
    avgRateElement.innerHTML = avgRate;

    filmsContainer.appendChild(clone);
}