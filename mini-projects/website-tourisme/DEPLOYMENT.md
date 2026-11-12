# Deploying Morocco Tourism

The portfolio routes this project through Vercel's PHP runtime. The app connects to Aiven PostgreSQL using the `DATABASE_URL` environment variable.

In the Vercel project settings, add `DATABASE_URL` for Production (and Preview if needed). Copy the PostgreSQL service URI from Aiven, including its password and `sslmode=require`. Keep the URI in Vercel's encrypted environment settings; do not commit it to this repository.

The database must contain the `destination`, `services`, and `reservations` tables used by the PHP pages. The ZIP did not include a database export, so this deployment expects those tables and destination/service records to already exist in Aiven.

After setting the variable and deploying, the portfolio card opens `/mini-projects/website-tourisme/index.php`; Vercel executes the PHP page instead of serving the PHP source as a download.
