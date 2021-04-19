This is a SIMPLE HTTP Notification HTTP Notification System.

Step 1. Create  Database PangaeaTest
Step 2. Run php artisan migrate to migrate the migration tables. This creates a dummy topic1, topic2, topic3 data on the topic tables.
Step 3. Test the API Endpoints

Postman Documentation: https://documenter.getpostman.com/view/6890514/TzJu8wZe

The subscribe endpont takes a url payload and saves to a table with the topicid ( In this case, it is assumed that a url and a topic cannot exist more than once)
the publish endpoint takes a message payload. When a message is published to a topic, it gets the subscribers of that topic and send a http request to them (the subscribers in this case is assumed to be the url).
If there are no subscribers, a http request will not be sent.

FEEL FREE TO CLONE!
