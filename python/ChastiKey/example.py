import ChastiKey as ck

# Initialise ChastiKey module
chastikey = ck.ChastiKey()

# Generate some random locks. Accepted parameters (both optional) are number_of_locks, and lock_level.
# number_of_locks will generate that number of locks, if left blank it will create 1.
# lock_level generates locks to a certain level between 1 and 10. 1. the shortest, and 10. the longest.
# lock_level sets the highest number allowed of each card type and is based on a percentage.
# For example the maximum reds allow in a deck is 399, level 1 would be 10% of that 399 so a maximum of 40 reds.
# Level 5 would be 50% so a maximum of 200 reds. Level 10 would be a maximum of 399 reds.
# The same logic applies for all card types so level 5 would be a maximum of 10 double ups.
# If lock_level is left blank (not included as a parameter) each lock will be created with a random level between 1 and 10.
#
# All locks are created with a regularity/draw interval of 1 hour.
# The thinking here is that the times saved for each lock can be multiplied by the required draw interval once searching is implemented.
chastikey.GenerateLocks(number_of_locks=10)

# At the moment DisplayStats just shows how many locks are saved in the database. I say database but it's a pickle file that pandas uses.
chastikey.DisplayStats()

# Save the database to an Excel so that you can easily see what's generated so far.
# The excel file is saved in the location where you're running the python script.
# You can pass through an excel file that includes the path if you want it saved somewhere else.
chastikey.SaveToExcel()

# If you want to clear all of the previous saved locks data you can by calling ClearLocks()
# chastikey.ClearLocks()
