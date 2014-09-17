# twtname
## Change your Twitter Display Name in given hours and days of week


### What is this?
This is a fun thing I've made. I just wanted to made my name change on Twitter if I'm at school, work and more... Since I'm almost going to school and to work at the same hours every week, I can actually make it working automaticly.


### What do I need to use it?
You will need to have...
- Read this "Readme"
- Git installed on your computer
- A computer (server) with PHP installed in it and with a permanant Internet connexion (I haven't tried to run it on Windows)
    + A Raspberry Pi left *always* on is totaly fine.
- Crontab (or any cron program that can work here)
- Twitter and register a Twitter App for the API keys to work
- 5-10 minutes


### What do I need to do?
- Git clone this repo with the submodules and go to his folder: 
    + `git clone --recursive https://github.com/mkody/twtname.git && cd twtname`
- Copy `twtname.exemple.conf` to `twtname.conf`
- Now, put a crontab job on this script! For exemple with my server, here's my cron to make it work every 10 minutes: `*/10 * * * * cd /home/mkody/twtname && /usr/bin/env php twtname.php > /dev/null 2>&1`
    + Note that with the ` > /dev/null 2>&1` at the end, you'll not keep logs or emails (Except if you want to test or be flooded every 10 minutes).
- And I think that's it! Now, let's configure it...


### How do I get this working now?
- Open the file `twtname.conf` and replace every "<...>" with the values you need.
- Below, you will see some some lines like 

````
1, 07:40, 10:10, I hate mondays
5, 16:00, 18:30, Friday!
````

For: Day of the week (N), Start time, End time, Display Name

1. **Day of the week (N)**: This need to be a number between 1 and 7. 1 is for Monday, 7 is for Sunday.
2. **Start time**: In 24hour format, the time when the display name (at then end of the line) should start displaying.
3. **End time**: In 24hour format, now when it will stop displaying
4. **Display Name**: The name to display with this configuration

> **NOTE:** The time and day of the week you enter is based on the time from the server! Check his timezone. 
> Also, you need to make a new line every time you need to add an another entry AND put a coma between "columns" **with a space after it**!

- If you want, you can also access this script from your browser to control it! But please, PLEASE, add a password to access it before with an .htaccess or something. You can move everything (yes everything, the ".files" too) on a web accessible folder with a server that supports PHP. 

- You can send "commands" to it! Just use the URL to the file and add `?s=` then your command:
    - `reset` will unlock the `Lock` option in the config file
    - `disable` will disable the script
    - `enable` enable the script again
    - And if you give any other value, the value becomes your display name and it'll be **Locked** (until you send `reset` again)


### What are those two first lines in the twtname.conf?
The fist line is to disable or enable the script. 
- `Disable: 0`: make the script run
- `Disable: 1`: make it not send your display name to twitter

The second line is to "Lock" your display name.
- `Lock: 0` or `Lock: `: will continue the script and use the scheduled names
- `Lock: <VALUE>` will use the `<VALUE>` every time and send it to Twitter. Can be cool if you are especially busy, for example, and you don't use your schedule now.


### Is it finished?
No. I need to do some improvements.


### Why Codebird-PHP?
I don't know, I'm just using it.


### Can we see your config file?
Sure! (except my keys, hehe)
```
Disable: 0
Lock: 0
Default: Kody
Email: im@kdy.ch
ConsumerKey: [HIDDEN]
ConsumerSecret: [HIDDEN]
TokenKey: [HIDDEN]
TokenSecret: [HIDDEN]

1, 08:10, 11:40, Kody|School
1, 09:45, 10:05, Kody|Pause
1, 12:40, 16:50, Kody|School
1, 15:05, 15:20, Kody|Pause

2, 08:10, 12:30, Kody|School
2, 09:45, 10:05, Kody|Pause
2, 13:30, 16:50, Kody|School
2, 15:05, 15:20, Kody|Pause

3, 08:00, 12:00, Kody|Work
3, 13:30, 17:30, Kody|Work

4, 08:00, 12:00, Kody|Work
4, 13:30, 17:30, Kody|Work

5, 08:00, 12:00, Kody|Work
5, 13:30, 17:30, Kody|Work
5, 21:00, 22:30, Kody|RB
```

---

## Thanks to:
- [HAL9000 and people on Stackoverflow for the little help](http://stackoverflow.com/a/25565783/2900156)
- And you for reading this line!
