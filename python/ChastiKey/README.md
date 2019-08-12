Something I've been writing on my bus journeys to and from work.

It's a python module that will generate random lock settings for ChastiKey (a bit like Remmie's Discord bot) and will save the locks to a datafile that can be added to each time it's run. You can also search that datafile to find suitable locks.

Each lock that's generated is ran through a number of simulation runs to get the best, average, and worst times which are also saved in the data. All locks are created with a regularity/draw interval of an hour but when you search for a lock that has a draw interval of 24 hours it will automatically multiply the saved lock times to fit that.

Feel free to take it away, play with it, update and make it better.

The example.py script shows how to call the available functions/commands.

There's also some dummy data saved as .dat (the pickle file) and .xlsx showing the couple of 1000 locks I've generated.
