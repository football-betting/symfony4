# Changelog

### Release 1.0.0

##### Functionality:
---
###### User management

* Registration
* Login
* Roles and page restriction

###### Betting

* bet can be placed until the match starts
* see past games
* global user scoreboard
* see all past games from another user
* see all past games from current user
* bet for worldcup winner
* score system:
    * correct games result: 3 points
    * correct score differance: 2 points
    * correct winner: 1 points
    * inaccurate score: 0 point
    * no bet placed: 0 point

###### Dashboard widgets

* current place in scoreboard
* last 10 games
* top 3 user in scoreboard
* bet can be placed on 4 upcomming matches

###### Integrated

* [Football-data.org API](<https://api.football-data.org/>) to:
    * create/update Teams
    * create/update games
* used template: [paper-dashboard](https://www.creative-tim.com/product/paper-dashboard)

### Release 1.0.1

---

* [Issue #13](https://github.com/football-betting/symfony4/issues/13) enabled versioning for css and js files to prevent browser caching of new changes
* [Issue #14](https://github.com/football-betting/symfony4/issues/14) negativ score now cannot be submitted
