# MWEvents
Simple event management system RESTful web app with CRUD functions. You can also join or leave events.

## AdminLTE

There is also a user interface for interacting with the web application, where you can see events, event participants, join or leave events.

![image](https://github.com/mwgiorno/mwevents/assets/43139928/2c4ccbaa-8ebb-4bc0-ac17-361002f76b97)

![image](https://github.com/mwgiorno/mwevents/assets/43139928/b3db8bb1-08fe-4178-8a0f-d8c1218eba5a)

## REST API
### Get all events
```bash
GET /api/events
```
### Get a specific event
```bash
GET /api/events/id
```
### Get user events
```bash
GET /api/user/events
```
### Create an event
```bash
POST /api/user/events
```
### Delete an event
```bash
DELETE /api/user/events/id
```
### Join an event
```bash
PUT /api/events/id/join
```
### Withdraw from an event
```bash
PUT /api/events/id/withdraw
```
### Sign Up
```bash
POST /api/register
```
### Sign In
```bash
POST /api/login
```
### Log out
```bash
POST /api/logout
```
## Technologies
* Laravel
* AdminLTE
* AlpineJS
* Axios
* MySQL/PostgreSQL
* NodeJS
