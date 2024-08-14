# Integrate Third-Party API for Weather Information

## Description:

Improve the experience of visitors to our office by offering real-time weather updates on the homepage of our website. This feature enables our visitors to effectively plan their activities according to the prevailing weather conditions.

## Acceptance Criteria:

- Use third party Weather API to fetch the weather details
- On home page show weather details like temperature, wind and precipitation
- Implement caching to retain weather data for a duration of one hour.
- Implement robust error handling to manage failed API requests or data parsing errors, ensuring the site’s front page remains functional

## API Configuration

- We have used [Weather API](https://www.weatherapi.com) as the weather service provider.
- Please enter the API key using the configuration form at `/admin/weather/settings`

## Block Configuration

- The module provides a block `Weather Display` which accepts the name of the City for which the weather
  needs to be displayed.
- You can place the block in any region using the Block Layout settings
