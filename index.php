<?php

use League\Csv\Writer;

## VARIABLE DECLARATIONS ##
# CTCSS Codes
$ctcss = ['67.0','69.3','71.9','74.4','77.0','79.7','82.5','85.4','88.5','91.5','94.8','97.4','100.0','103.5','107.2','110.9','114.8','118.8','123','127.3','131.8','136.5','141.3','146.2','151.4','156.7','162.2','167.9','173.8','179.9','186.2','192.8','203.5','210.7','218.1','225.7','233.6','241.8','250.3'];



## END VARIABLE DECLARATIONS ##

## BEGIN HEADER DECLARATIONS ##
# Channel List Headers
$channel_list_header = [
    'No.',                              // Auto increment in order of entries input into template
    'Channel Name',                     // Template - Name of channel (*Limited to 16 characters, Limited to 4,000 entries)
    'Receive Frequency',                // Template - ###.#####
    'Transmit Frequency',               // Template - ###.#####
    'Channel Type',                     // Template - A-Analog or D-Digital
    'Transmit Power',                   // Template - Low, Medium, High, or Turbo
    'Band Width',                       // Template - 12.5K or 25K
    'CTCSS/DCS Decode',                 // Template - ctcss array of frequencies
    'CTCSS/DCS Encode',                 // Template - ctcss array of frequencies
    'Contact',                          // Template - Talk Group name (need to check against imported talk groups)
    'Contact Call Type',                // Private Call or Group Call, set by Contact selection once populated in template
    'Radio ID',                         // Users RadioId (Should be input in text field)
    'Busy channel Lock-Out/TX Permit',  // Template - If Channel Type=A-Analog: Busy Channel Lock-Out = Off, Repeater, Busy (Default: Off)
                                        // If Channel Type=D-Digital: TX-Permit = Always, ChannelFree, Different Color Code, Same Color Code (Default: Always)
    'Squelch Mode',                     // Template - If Channel Type=A-Analog AND CTCSS/DCS Decode<>Off: Carrier, CTCSS/DCS (Default: Carrier)
    'Optional Signal',                  // If Channel Type=A-Analog: Off, DTMF, 2Tone, 5Tone (Default: Off)
    'DTMF ID',                          // If Channel Type=A-Analog AND Optional Signal=DTMF (Default: NULL) 
    '2Tone ID',                         // If Channel Type=A-Analog AND Optional Signal=2Tone (Default: 1)
    '5Tone ID',                         // If Channel Type=A-Analog AND Optional Signal=5Tone (Default: 1)
    'PTT ID',                           // If Channel Type=A-Analog: Off, Start, End, Start&End (Default: Off)
    'Color Code',                       // Template - If Channel Type=D-Digigal: Array 0-15 (Default: 1)
    'Slot',                             // Template - If Channel Type=D-Digital: Slot1 or Slot2 (Default: Slot1)
    'Receive Group List',               // Template - Sets Receive group list to generate with this entry (Default: None)
    'TX Prohibit',                      // Off, On Default: Off)
    'Reverse',                          // Default: Off)
    'Simplex TDMA',                     // If Channel Type=D-Digital: Off, On (Default: Off)
    'TDMA Adaptive',                    // If Channel Type=D-Digital: Off, On (Default: Off)
    'Encryption Type',                  // Normal Encryption, Enhanced Encryption (Default: Normal Encryption)
    'Digital Encryption',               // Off, 1-32 (Default: Off)
    'Call Confirmation',                // Off, On (Default: Off)
    'Talk Around',                      // Off, On (Default: Off)
    'Work Alone',                       // Off, On (Default: Off)
    'Custom CTCSS',                     // Open numerical field (Default: 251.1)
    '2TONE Decode',                     // Number (Default: 1)
    'DTMF Own ID',                      // Number (Default: 1)
    '5TONE Own ID',                     // Number (Default: 1)
    'Scan List 1',                      // Template - Sets scan list(s) to generate with this entry (*Limited to 16 characters) (Default: NULL)
    'Scan List 2',                      // Template - Default: NULL
    'Scan List 3',                      // Template - Default: NULL
    'Scan List 4',                      // Template - Default: NULL
    'Scan List 5',                      // Template - Default: NULL
    'Scan List 6',                      // Template - Default: NULL
    'Scan List 7',                      // Template - Default: NULL
    'Scan List 8',                      // Template - Default: NULL
    'Ranging',                          // If Channel Type=D-Digital: Off, On (Default: Off)
    'Through Mode',                     // Off, On (Default: Off)
    'Exclude Channel From Roaming',     // Template - Off or On (Default: Off)
    'APRS Report Channel',              // Template - Array 1-8 (Default: 1)
    'AES Digital Encryption',           // 0, 1 (Default: 0)
    'Multiple Key',                     // 0, 1 (Default: 0)
    'Random Key',                       // 0, 1 (Default: 0)

# Additional Channel List Header Fields NOT in Generated Upload CSV
    'APRS Report Type',                 // Template - Off, Analog, Digital (Default: Off)
    'Analog APRS PTT Mode',             // Off, Start Of Transmission, End Of Transmission (Default: Off)
    'Digital APRS PTT Mode',            // Off, On (Default: Off)
    'Digi Aprs Rx',                     // On, Off (Default: Off)
    'DataACK Disable',                  // On, Off (Default: Off)
    'Zone Channel List'                 // Template - *Custom Field, Sets Zone List Membership (*Limited to 16 characters, Limited to 250 entries per zone)
];

# Zone List Headers
$zone_list_header = [
    'No.',                              // Auto increment in order of entries input into template
    'Zone Name',                        // Name of zone list, set from scan list names in channel list (*Limited to 16 characters)
    'Zone Channel Member',              // '|' Separated channel list names, aggregated from zone list fields in channel list (*Limited to 250 entries per zone)
    'A Channel',                        // Default to channel 1 in Zone Channel Members list
    'B Channel'                         // Default to channel 2 in Zone Channel Membners list
];

# Scan List Headers
$scan_list_header = [
    'No.',                              // Auto increment in order of entries input into template
    'Scan List Name',                   // Name of scan list, set from scan list names in channel list (*Limited to 16 characters)
    'Scan Channel Member',              // '|' Separated channel list names, aggregated from non-null scan list fields in channel list (*Limited to 50 entries per scan list)
    'Scan Mode',                        // On, Off (Default: Off)
    'Priority Channel Select',          // Priority Channel Select1, Priority Channel Select2, Priority Channel Select1 + Priority Channel Select2 (Default: Off)
    'Priority Channel 1',               // Selected from Scan Channel Member list (Default: Off)
    'Priority Channel 2',               // Selected from Scan Channel Member list (Default: Off)
    'Revert Channel',                   // Selected, Selected + TalkBack, Priority Channel Select1, Priority Channel Select2, Last Called, Last Used, Priority Channel Select1 + TalkBack, Priority Channel Select2 + TalkBack, set to Selected + TalkBack (Default: Selected) 
    'Look Back Time A[s]',              // 0.5-5.0 (.1 increments) (Default: 1.5)
    'Look Back Time B[s]',              // 0.5-5.0 (.1 increments) (Default: 2.5)
    'Dropout Delay Time[s]',            // 0.1-5.0 (.1 increments) (Default: 2.9)
    'Dwell Time[s]'                     // 0.1-5.0 (.1 increments) (Default: 2.9)
 ];

# Roaming Channel List Headers
$roaming_channel_list_header = [
    'No.',                              // Auto increment in order of entries input into template
    'Receive Frequency',                // ###.#####
    'Transmit Frequency',               // ###.#####
    'Color Code',                       // Array 0-15 (Default: 1)
    'Slot',                             // Slot1 or Slot2 (Default: Slot1)
    'Name'                              // Zone list to generate with this entry (*Limited to 16 characters)
];

# Roaming Zone List Headers
$roaming_zone_list_header = [
    'No.',                              // Auto increment in order of entries input into template
    'Zone Name',                        // Name of zone list, set from Roaming Zone names in Roaming Channel List (*Limited to 16 characters)
    'Zone Channel Member',              // '|' Separated channel list names, aggregated from Roaming Zone List fields in Roaming Channel List (*Limited to 50 entries per roaming zone list)
    'A Channel',                        // Default to channel 1 in Zone Channel Members list
    'B Channel'                         // Default to channel 2 in Zone Channel Membners list
];

# Receive Group Call List Headers
$receive_group_call_list_header= [
    'No.',
    'Group Name',                       // Name of receive group, set from Receive Group 
    'Contact'                           // '|' Separated contact list names, aggregated from Receive Group List fields in channel list (*Limited to 50 entries per receive list)
];
## END HEADER DECLARATIONS ##

## START RECORDS POPULATION ##
# Channel List Records
$channel_list_records = [
    [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50],
    ['#',
    'name_of_channel',
    'rx_frequency',
    'tx_frequency',
    'channel_type',
    'transmit_power',
    'band_width',
    'ctcss/dcs_decode',
    'ctcss/dcs_encode',
    'contact_name/talk_group',
    'contact_call_type', // 'Private Call' OR 'Group Call'
    'radio_id',
    'busy_channel_lock-out/tx_permit', // IF Channel Type=A-Analog='Off' ELSE IF Channel Type=D-Digital='Always'
    'squelch_mode', // 'Carrier'
    'Off',
    'NULL',
    '1',
    '1',
    'Off',
    'Color Code', // IF Channel Type=D-Digigal='1'
    'Slot', // IF Channel Type=D-Digital='Slot1'
    'receive_group_list',
    'Off',
    'Off',
    'Off',
    'Off',
    'Normal Encryption',
    'Off',
    'Off',
    'Off',
    'Off',
    '251.1',
    '1',
    '1',
    '1',
    'scan_list_1',
    'scan_list_2',
    'scan_list_3',
    'scan_list_4',
    'scan_list_5',
    'scan_list_6',
    'scan_list_7',
    'scan_list_8',
    'Off',
    'Off',
    'Off',
    '1',
    '0',
    '0',
    '0'
    ]
];

# Zone List Records
$zone_list_records = [
    [1, 2, 3, 4, 5],
    ['#','zone_list_name1','zone|channel|members1','zone_channelA1','zone_channelB1'],
    ['#','zone_list_name2','zone|channel|members2','zone_channelA2','zone_channelB2']
];

# Scan List Records
$scan_list_records = [
    [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
    ['#','scan_list_name1','scan|channel|members1','Off','Off','Off','Off','Off','1.5','2.5','2.9','2.9'],
    ['#','scan_list_name2','scan|channel|members2','Off','Off','Off','Off','Off','1.5','2.5','2.9','2.9']
];

# Roaming Channel List Records
$roaming_channel_list_records = [
    [1, 2, 3, 4, 5, 6],
    ['#','roaming_rx_frequency1','roaming_tx_frequency1','roaming_color_code1','roaming_slot_num1','roaming_channel_name1'],
    ['#','roaming_rx_frequency2','roaming_tx_frequency2','roaming_color_code2','roaming_slot_num2','roaming_channel_name2']
];

# Roaming Zone List Recods
$roaming_zone_list_records = [
    [1, 2, 3, 4, 5],
    ['#','roaming_zone_list_name1','roaming|zone|channel|members1','roaming_zone_channelA1','roaming_zone_channelB1'],
    ['#','roaming_zone_list_name2','roaming|zone|channel|members2','roaming_zone_channelA2','roaming_zone_channelB2']
];

# Receive Group Call List Records
$receive_group_call_list_records = [
    [1, 2, 3],
    ['#','receive_group_name1','receive|group|channel|members1'],
    ['#','receive_group_name2','receive|group|channel|members2']
];

## END RECORDS POPULATION ##

//load the CSV document from a string
$csv = Writer::createFromString();

//insert the header
$csv->insertOne($header);

//insert all the records
$csv->insertAll($records);

echo $csv->toString(); //returns the CSV document as a string

# TODO Talk Group list file importer for reference

# TODO Contacts list import for core files generation

# TODO Template file downloader after initial reference files are imported for reference

# TODO Completed template file uploader

# TODO File check - value checks

# TODO Additional info gathering and clarifications (if necessary)

# TODO RadioID entry

# TODO CPS file generation


?>