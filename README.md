CookieOven
==========

README ;)

==========


The CookieOven is a proof of concept. I was new to using cookies, and required a way to save a registration form via cookies. The client requested to not keep any information in a database, or files, yet wanted the user to be able to close the form and return to it at a later date. Our initial idea was cookies.

The registration form had repeatable sections, and therefore there was no set size for our data. It could be 5 fields, it could be 500 fields. We didn't know - but this is what I came up with.

I wouldn't recommend using this because, as we discovered, saving long strings as cookies can really interfere with header requests to the server - and most likely cause you 400 errors. If this happens, clear your cookies for the site. As a result, this code wasn't used in the end and we persuaded the client to go the database route (and delete records once the form was submitted).

Still, I enjoyed this class that I created, and think it's quite cute. Enjoy my yummy naming convention!