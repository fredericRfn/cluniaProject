import pakbus
import socket
import sys

# This program is responsible for retrieving the files produced by the
# dataloggers, store them and put them in the database

# STEP 1: Connect to the Dataloggers and download the files

#
# Initialize parameters
#
# Parse command line arguments
import optparse
parser = optparse.OptionParser()
parser.add_option('-c', '--config', help = 'read configuration from FILE [default: %default]', metavar = 'FILE', default = 'pakbus.conf')
(options, args) = parser.parse_args()

# Read configuration file
import ConfigParser, StringIO
cf = ConfigParser.SafeConfigParser()
print 'configuration read from %s' % cf.read(options.config)

# Data logger PakBus Node Id
NodeId = int(cf.get('pakbus', 'node_id'),0)
# My PakBus Node Id
MyNodeId = int(cf.get('pakbus', 'my_node_id'),0)

# Open socket
s = pakbus.open_socket(cf.get('pakbus', 'host'), cf.getint('pakbus', 'port'), cf.getint('pakbus', 'timeout'))

# check if remote node is up
msg = pakbus.ping_node(s, NodeId, MyNodeId)
if not msg:
    raise Warning('no reply from PakBus node 0x%.3x' % NodeId)

#
# Main program
#
# List files in directory
filedir = pakbus.parse_filedir(FileData)
for file in filedir['files']:
    print file

# say good bye
pakbus.send(s, pakbus.pkt_bye_cmd(NodeId, MyNodeId))

# close socket
s.close()

