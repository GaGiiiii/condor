# CONDOR  

User manual for installing and starting the application

## Installing project

### Prerequisites:

- Installed [GIT CLI](https://git-scm.com/)
- Installed [Docker](https://docs.docker.com/get-docker/)  

---

We are going to clone repo with command

```bash
git clone https://github.com/GaGiiiii/condor/
```

Enter the project directory

```bash
cd condor
```

Finally start the application by running the command

```bash
docker-compose up -d
```

You can run test by typing the following command

```bash
docker-compose exec app ./vendor/bin/phpunit ./app/tests/statistics/StatisticsTest.php 
```

---

## API Documentation  

---

### Auth

--- 

#### Login

```http
POST /v1/login
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `username` | `string` | Users username. |

### Statistics

---

#### Get statistics

```http
GET /v1/fetch
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `type` | `string` | **Optional** Available values for this attribute are: day, week, month, year, period. If period is provided, startDate and endDate parameters becomes required. |
| `startDate` | `string` | **Optional** Start date. |
| `endDate` | `string` | **Optional** End date. |

### Users

---

#### Get all users

```http
GET /v1/users
```

#### Get single user

```http
GET /v1/users/{id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id` | `integer` | **Required** ID of the user that you are looking for. |

---

## Responses

API returns a JSON response in the following format:

```javascript
{
  "error": boolean,
  "message": string,
  "data": data,
  "?token": string,
}
```
The `message` - attribute contains a message commonly used to indicate errors or success messages.

The `data` - attribute contains requested resource/s or processed resource.  

The `errors` - indicates if there are erros present.

The `token` - attribute is optional and it will be returned when user logins.

## Status Codes

API returns the following status codes:

| Status Code | Description |
| :--- | :--- |
| 200 | `OK` |
| 201 | `CREATED` |
| 400 | `BAD REQUEST` |
| 404 | `NOT FOUND` |
| 422 | `UNPROCESSABLE CONTENT` |
| 500 | `INTERNAL SERVER ERROR` |





