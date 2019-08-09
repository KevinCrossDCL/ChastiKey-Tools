Something I've been writing on my bus journeys to and from work.

It's a python module that will generate random locks (a bit like Remmie's bot) and will save the locks to a datafile that can be added to each time it's run. You can also search that datafile to find suitable locks.

Each lock that's generated is ran through a number of simulation runs to get the best, average, and worst times which are also saved in the data. All locks are created with a regularity/draw interval of an hour. I chose this as I thought it should be easily enough to multiply by the desired draw interval once searching is available.

Feel free to take it away, play with it, update and make it better.

The example.py script shows how to call the available functions/commands.

There's also some dummy data saved as .dat (the pickle file) and .xlsx showing the couple of 1000 locks I've generated.
