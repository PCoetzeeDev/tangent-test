# Test Project for Tangent

### How to run this app
Step 1: First clone the repo

    git clone git@github.com:PCoetzeeDev/tangent-test.git && cd tangent-test
Step 2: Add the following domain in your hosts file pointing to localhost, like so:

    127.0.0.1       tangenttest.local        tangenttest
Step 3: Go into the docker folder, run the env.sh script

    cd docker && ./env.sh
**IMPORANT - Step 4:** Edit both the /docker/.env .There are settings in there that define paths on your local machine. The laravel example should be fine as is though

Step 5: Next, run the up.sh script which should build and start the app

    ./up.sh

That should be it!

--------------------------------------------------------------------------------------------------------------------------------

### Other useful scripts in /docker
    seed.sh
Run the db seed and populates it with random data

    test.sh
Run the automated tests - Will clear out the db currently!

    log.sh
Attach to the app and watch the logs

    down.sh
Bring the app down

