from subprocess import call;
from os import listdir, remove;
from os.path import isfile, join;
import shutil;
call("cd stomp-websocket", shell=True);
call("cake build", shell=True);
call("cd ..", shell=True);
#call("", shell=True);
call("stomp-websocket\\node_modules\\.bin\\uglifyjs -m --comments all -o stomp-websocket/lib/stomp.min.js stomp-websocket/lib/stomp.js", shell=True);
