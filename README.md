# Access SCORM Plugin for Moodle
## Overview
This plugin allows token-based access to SCORM packages in Moodle, enabling users from external systems to access SCORM course content directly, without needing to log in manually. It is particularly useful if you want to integrate Moodle's SCORM content into another application or website while managing user authentication separately.

By using this plugin, you can grant seamless access to SCORM activities for users authenticated in your external system, improving integration and user experience across platforms.

## Features
Provides access to Moodle SCORM packages via token-based authentication.
Allows external applications to interact with Moodle SCORM content without manual login.
Works well with Moodle’s built-in web services, using tokens to authenticate requests.

## Installation
1. In Moodle, go to **Site administration > Plugins > Install plugins** to install the plugin using a .zip file. 
2. Complete the installation process by following the prompts.


## Configuration
1. Ensure that Web services and REST protocol are enabled in Moodle:
    - Go to ***Site administration > Advanced*** features and enable Web services.
    - Go to ***Site administration > Plugins > Web services > Manage protocols*** and enable REST protocol.
2. Create or select an existing user in Moodle for API access.

## Usage
Once the plugin is installed and configured, follow these steps to access Moodle SCORM content via an external system.

### Step 1: Obtain an Authentication Token
Your external application needs to request an authentication token from Moodle. This token will be used for secure, token-based access to SCORM content.

- Make a request to the Moodle token endpoint:
```curl
    https://yourmoodle.hostname/login/token.php?username=<youruser>&password=<yourpassword>&service=moodle_mobile_app
```
- Replace ```<youruser>``` and ```<yourpassword>``` with the credentials of the Moodle user you’re using for API access.

- Replace moodle_mobile_app with your service name if you’re using a custom web service.

- The response will be in JSON format:

```json
{"token": "yourtoken"}
```

### Step 2: Access SCORM Content with the Token
With the token in hand, you can now access SCORM content directly using the plugin’s access URL.

- Use the following URL format to access SCORM content:
plaintext
```curl
https://yourmoodle.hostname/local/access_scorm/access_scorm.php?token=<yourtoken>&scoid=<scormid>&cm=<cmid>
```
- Replace <yourtoken> with the token obtained in Step 1.
- Replace <scormid> with the SCORM package ID you want to access.
- Replace <cmid> with the course module ID associated with the SCORM package.

### Example
If you have a SCORM package with scormid=66 and cmid=20, and your token is abc123token, your URL would look like:

``` curl
https://yourmoodle.hostname/local/access_scorm/access_scorm.php?token=abc123token&scoid=66&cm=20
```

## Troubleshooting
- **Invalid Token**: If you receive an "Invalid token" error, make sure the token is correct and hasn’t expired. Tokens may have a limited lifespan depending on Moodle’s configuration.
- **Permission Denied**: Ensure the Moodle user associated with the token has access to the SCORM activity.
- **Token Expiry** : Tokens generated via Moodle’s web services may expire based on the Moodle configuration. Regenerate tokens as needed.

## Security Considerations
- Always use HTTPS for requests to Moodle, especially when transmitting tokens, to prevent unauthorized access.
- Restrict access to the plugin to only trusted users and systems, as this plugin enables access to Moodle content without login.
- Consider implementing additional security measures on your external system, such as IP whitelisting or request rate limiting.

## Development
### Requirements
- Moodle 3.11 or later
- PHP 7.4 or higher

### Versioning
This plugin follows Moodle’s versioning format, with the version number defined in version.php.

### Contributing
Contributions are welcome! Please fork the repository and submit a pull request with any improvements or new features. Ensure that your code adheres to Moodle’s coding standards.