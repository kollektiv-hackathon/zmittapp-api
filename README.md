zmittapp REST API
========================

Restful API (built with Symfony2) to provide functionality for owners and users.

# Oauth

**Client-Id** and **Client-Secret** will be generated with execution of *pull.php* (api.zmittapp.ch/pull.php)

## Users

The following demo accounts will be created during fixtures load:

| Username       | Password  | Restaurant |
|----------------|:----------|:-----------|
| info@aubrey.ch | secret    | Aubrey     |

## Access Token
On login/legister the access token (Resource Owner Password Credentials Grant) can be retrieved using the following arguments:

	http://zmittapp.api/oauth/v2/token?client_id=[CLIENT_ID_YOU GENERATED]&client_secret=[SECRET_YOU_GENERATED]&grant_type=password&username=[USERNAME]&password=[PASSWORD]

## Authorization
The provided access token can be used either by providing an url parameter (1) or by a header field (2, preferred):
    
    (1) http://zmittapp.api/profile/?access_token=[TOKEN]
    
    (2) Authorization: Bearer [TOKEN]
    
## Scope

Supported scopes:

| Scope    | Description      |
|----------|:-----------------|
| owner    | Restaurant owner |