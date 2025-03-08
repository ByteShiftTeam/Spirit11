document.addEventListener('DOMContentLoaded', function () {
    const categories = document.querySelectorAll('.category-btn');
    const playersList = document.getElementById('players');
    const userTeamDiv = document.getElementById('userTeam');

    let userTeam = []; // Store player's ids that the user selects

    // Handle category selection
    categories.forEach(button => {
        button.addEventListener('click', function () {
            const category = this.getAttribute('data-category');
            loadPlayers(category); // Load players for the selected category
        });
    });

    // Fetch players by category
    function loadPlayers(category) {
        fetch(`selectTeam.php?category=${category}`)
            .then(response => response.json())
            .then(players => {
                playersList.innerHTML = '';
                players.forEach(player => {
                    const playerCard = document.createElement('div');
                    playerCard.classList.add('player-card');
                    playerCard.innerHTML = `
                        <p><strong>${player.name}</strong></p>
                        <p>University: ${player.university}</p>
                        <p>Budget: $${player.budget}</p>
                        <button class="add-to-team-btn" data-id="${player.id}">Add to Team</button>
                    `;
                    playersList.appendChild(playerCard);
                });
            })
            .catch(error => console.error('Error fetching players:', error));
    }

    // Add player to team
    playersList.addEventListener('click', function (event) {
        if (event.target.classList.contains('add-to-team-btn')) {
            const playerId = event.target.getAttribute('data-id');

            if (userTeam.includes(playerId)) {
                alert('Player already in your team!');
            } else {
                // Send request to add player to the team
                fetch('addPlayerToTeam.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `player_id=${playerId}`,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        userTeam.push(playerId); // Add to local team list
                        updateTeamDisplay();
                    } else {
                        alert(data.error);
                    }
                })
                .catch(error => console.error('Error adding player to team:', error));
            }
        }
    });

    // Display the user's current team
    function updateTeamDisplay() {
        userTeamDiv.innerHTML = ''; // Clear the current display
        userTeam.forEach(playerId => {
            fetch(`getPlayerDetails.php?id=${playerId}`)
                .then(response => response.json())
                .then(player => {
                    const playerDiv = document.createElement('div');
                    playerDiv.innerHTML = `
                        <p>${player.name} (${player.university})</p>
                        <button class="remove-from-team-btn" data-id="${player.id}">Remove</button>
                    `;
                    userTeamDiv.appendChild(playerDiv);
                });
        });
    }

    // Remove player from team
    userTeamDiv.addEventListener('click', function (event) {
        if (event.target.classList.contains('remove-from-team-btn')) {
            const playerId = event.target.getAttribute('data-id');
            userTeam = userTeam.filter(id => id !== playerId);
            updateTeamDisplay();
        }
    });
});
