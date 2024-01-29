# Project Plan

### Purpose
The purpose of the platform we are going to make is for the hero association to manage all heroes and their ELO. Their should also be a match making & simulating feature.

### Scope
We are going to implement the following features into our platform:

**Heroes registration**<br>
A new hero will be able to register itself on the platform by filling out the following fields:
* Legal name
* Hero alias
* Email
* Phone
* Password
* Date of birth
* Backstory

After that the hero should be able to choose a primary power and secondary powers, these will be predefined from an admin panel of the heroes association.

If they are registered they will get an starting ELO of 1200, this can improve based on the matches they play

**Hero Battle Matches**<br>
A hero will be able to request a match, the match will be organized based on the given heroes availability & ELO. The match will be simulated via the backend of the platform. The winner of the match will receive an increase of their ELO, and the loser will receive a decrease in their ELO.

**Api**<br>
We are also going to make an Api for other developers to implements our features on their platform. Via the Api you should be able to create & simulate a new match. This will affect the main platforms database (our database). So if a develop creates a new match between heroes their ELO will be influenced based on the outcome of the match

**Hero association dashboard**<br>
We will also be making a dashboard for the hero association, here they can view all heroes & create and manage powers.

**Leaderboard**<br>
A guest user will be able to see a leaderboard between all heroes with all of their ratings.

### User Stories
| Feature                        | As a...   | I want to...                                                              | So that...                                                                  |
|--------------------------------|-----------|---------------------------------------------------------------------------|-----------------------------------------------------------------------------|
| **Heroes Registration**        | Hero      | Register on the platform                                                  | I can officially become part of the hero association and engage in battles. |
|                                |           | Fill out my legal name, alias, email, phone, password, DOB, and backstory | My identity and hero profile are correctly set up in the system.            |
|                                |           | Choose a primary power and secondary powers                               | I can showcase my unique abilities in battles.                              |
|                                |           | Receive a starting ELO of 1200                                            | I have a baseline for tracking my performance in battles.                   |
| **Hero Battle Matches**        | Hero      | Request a match                                                           | I can engage in battles to improve my skills and ELO rating.                |
|                                |           | Have matches organized based on availability & ELO                        | The battles are fair and fit into my schedule.                              |
|                                |           | Participate in simulated matches                                          | I can compete with other heroes without physical confrontation.             |
|                                |           | Have ELO adjusted based on match outcomes                                 | My ranking reflects my performance in battles.                              |
| **API**                        | Developer | Access the API to implement features on external platforms                | I can extend the functionality of the hero platform to other applications.  |
|                                |           | Create and simulate new matches via the API                               | Users on my platform can engage in battles that affect their ELO.           |
| **Hero Association Dashboard** | Admin     | View all registered heroes                                                | I can oversee and manage the hero community effectively.                    |
|                                | Admin     | Create and manage powers                                                  | I can ensure a diverse and balanced range of abilities for heroes.          |
| **Leaderboard**                | Guest     | View the leaderboard of heroes                                            | I can see the rankings and ratings of all the heroes.                       |

### Technologies
We are going to use TALL stack for our platform:
<br>(T) Tailwind, this is a css library.
<br>(A) AlpineJS, This is a front-end framework.
<br>(L) Laravel, This is a back-end php framework.
<br>(L) Livewire, This is a full-stack framework for Laravel that allows you to build dynamic UI components without leaving PHP.

We are also going to use Filament to create our dashboards.

### Database design
WIP

### Planning
| Day    | Time       | Finn                                                          | Lietze                                                          |
|--------|------------|---------------------------------------------------------------|-----------------------------------------------------------------|
| Day 1  | Morning    | Start "Heroes Registration" interface design.                 | Begin backend setup for user registration.                      |
|        | Afternoon  | Continue with registration form, focusing on power selection. | Develop API endpoints for hero registration.                    |
| Day 2  | Morning    | Design user interface for "Hero Battle Matches" requests.     | Implement match-making algorithm based on ELO and availability. |
|        | Afternoon  | Work on match simulation interface.                           | Start developing ELO calculation logic post-match.              |
| Day 3  | Morning    | Design "Hero Association Dashboard" admin interface.          | Develop backend for leaderboard feature.                        |
|        | Afternoon  | Finalize frontend tasks or start leaderboard interface.       | Finalize and test API for external developers.                  |
|        | End of Day | Review accomplished tasks.                                    | Review accomplished tasks.                                      |

