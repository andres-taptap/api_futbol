//Variables obligatorias
var landscape = false;
var tablet = false;
var video_scale = 320 / 480;
var mapShow = false;
var thirdPartyTracks = {
    notifyVideoStarted: '',
    notifyFirstQuartile: '',
    notifyMidPoint: '',
    notifyThirdQuartile: '',
    notifyVideoEnded: ''
};
if (trackEventsSonata !== '') {
    thirdPartyTracks = {
        notifyVideoStarted: trackEventsSonata + 'video_start',
        notifyFirstQuartile: trackEventsSonata + 'video_firstQuartile',
        notifyMidPoint: trackEventsSonata + 'video_midpoint',
        notifyThirdQuartile: trackEventsSonata + 'video_thirdQuartile',
        notifyVideoEnded: trackEventsSonata + 'video_complete'
    };
}
;
//--

function checkDisplayCustom() { //No borrar esta función
    // ORIENTATION   
    if (landscape) {

    } else {

    }
    //DEVICE
    if (tablet) {

    } else {

    }
}

function changePage(newpage) { //No borrar esta función
    animatePage(newpage);
    if (newpage === 'formpage') {
        initForm();
    }
}

function showModalBox(modalbox) { //No borrar esta función
//    if(modalbox === 'modalBox'){
//        trackingEvent('Popup', 'Mostrar popup', 'Mostrar popup',thirdPartyTracks.modalBoxTrack);
//    }   
}

function animatePage(page) { //No borrar esta función
    if (page === 'homepage') {

    }
}

$(document).ready(function () {
    animatePage('homepage');
    marcadores();

});

var id;
var fecha;
var homeTeamId;
var awayTeamId;
var awayTeam;
var homeTeam;
var homeGoals;
var awayGoals;
let winner;

function marcadores() {
    const settings = {
        async: true,
        crossDomain: true,
        url: 'https://api-football-v1.p.rapidapi.com/v3/fixtures?league=9&season=2024',
        method: 'GET',
        headers: {
            'X-RapidAPI-Key': '5253e37122msha7f6cf1ba324d19p1cbcf6jsn0fca20d580a1',
            'X-RapidAPI-Host': 'api-football-v1.p.rapidapi.com'
        }
    };

    $.ajax(settings).done(function (response) {
        console.log(response);
        let fixtures = response.response;
        let htmlContent = '<ul>';

        const promises = fixtures.map(fixture => {
            homeTeamId = fixture.teams.home.id;
            awayTeamId = fixture.teams.away.id;
            homeTeam = fixture.teams.home.name;
            awayTeam = fixture.teams.away.name;

            // Ajuste de la fecha aquí
            fecha = new Date(fixture.fixture.date).toISOString().slice(0, 19).replace('T', ' ');

            id = fixture.fixture.id;

            if (fixture.hasOwnProperty('goals')) {
                homeGoals = fixture.goals.home;
                awayGoals = fixture.goals.away;
                winner = homeGoals > awayGoals ? homeTeam : awayGoals > homeGoals ? awayTeam : 'Draw';
            } else {
                winner = ' - Goals not available, winner cannot be determined';
            }

            let goals;
            if (fixture.hasOwnProperty('goals')) {
                goals = ` - Goals: ${fixture.goals.home} - ${fixture.goals.away}`;
            } else {
                goals = ' - Goals: Not Available';
            }

            htmlContent += `
            <li>
                <b>${id}</b> - ${fecha} - ${homeTeamId} - ${homeTeam} vs ${awayTeamId} - ${awayTeam}
                ${goals}
                <br>
                <b>Winner:</b> ${winner}
            </li>
        `;

            // Return a promise from the fetch call
            return fetch("includes/functions_form.php", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    name: "taptap",
                    id: id,
                    fecha: fecha,
                    homeTeam: homeTeam,
                    awayTeam: awayTeam,
                    homeGoals: homeGoals,
                    awayGoals: awayGoals,
                    winner: winner,
                    homeTeamId: homeTeamId,
                    awayTeamId: awayTeamId
                })
            });
        });

        htmlContent += '</ul>';
        $('#resultados_copa').html(htmlContent);

        // Wait for all fetch requests to complete
        Promise.all(promises)
                .then(responses => {
                    responses.forEach(response => {
                        if (!response.ok) {
                            console.error("Error in response:", response);
                        }
                    });
                    console.log("All requests completed");
                })
                .catch(error => {
                    console.error("Error with fetch requests:", error);
                });

    }).fail(function (error) {
        console.error("Error al obtener los datos:", error);
        $('#resultados_copa').html("<p>Error al obtener los datos.</p>");
    });

}


