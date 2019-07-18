The chastikey_schema.sql file shows the latest tables structure that the ChastiKey app uses.

There are some columns in the tables that aren't used yet and may change in the next version of the app.

Also most of the tables have _V2 at the end of their names because of a major change that needed to be made to the tables in an earlier version. Creating new tables meant that old versions of the app could still run without issues. That isn't something I plan to do again.

Column names in each table are sorted alphabetically, except for any id ones which are added to the front of each table. Keeping it alphabetically may not be the norm, but it makes it easier finding columns especially when some of the tables have a lot of columns.

Indexes have typically been applied to columns that are used a lot when matching up records between tables, so columns like, id, user_id, share_id, and lock_id etc.
