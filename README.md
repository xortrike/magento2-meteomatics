# Weather from Meteomatics

### Useful links

Register free account:
https://www.meteomatics.com/en/sign-up-weather-api-test-account/

Getting Started:
https://www.meteomatics.com/en/api/getting-started/

Available Parameters:
https://www.meteomatics.com/en/api/available-parameters/

### Client task

```text
Preparation of a module for collecting weather data from the API https://www.meteomatics.com/en/ service.
create an account in API service (free 2 weeks trial)
data should be downloaded for the selected location according to the LAT and LONG values   provided in the store's configuration and saved in the database
the database record should be displayed in the administration panel
in the admin grid, you should add filtering of records based on the date of adding the record, using the "range" type field
create an installer for the CMS block that is responsible for displaying information about the weather based on the latest record in the database
CMS block should be added to store's footer
data displayed on the CMS block should not be cached
data should be downloaded from the API https://www.meteomatics.com/en/ service using the cron job 
add an ability to select data type (assume json, xml and csv) from system settings, implementation of data type handler can be omitted
Expose Magento Web API endpoint to provide an ability to fetch weather data. Endpoint should not be declared as an anonymous resource.
```

### Module

_Admin panel_

Module page: Content -> Meteomatics -> Weather

Configurations: Services -> Meteomatics
