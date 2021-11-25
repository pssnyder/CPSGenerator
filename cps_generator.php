<?php

use League\Csv\Writer;

## VARIABLE DECLARATIONS ##
# CTCSS Codes
$ctcss = ['67.0','69.3','71.9','74.4','77.0','79.7','82.5','85.4','88.5','91.5','94.8','97.4','100.0','103.5','107.2','110.9','114.8','118.8','123','127.3','131.8','136.5','141.3','146.2','151.4','156.7','162.2','167.9','173.8','179.9','186.2','192.8','203.5','210.7','218.1','225.7','233.6','241.8','250.3'];


# TODO Talk Group list file importer for reference

# TODO Contacts list import for core files generation


## FILE BUILD FUNCTIONS ##

# TODO Template file downloader after initial reference files are imported for reference
## Build Template File
function buildTemplateFile() {
    # User File Template Headers
    $template_header = [
        'Channel Name',                     // Template - Name of channel (*Limited to 16 characters, Limited to 4,000 entries)
        'Receive Frequency',                // Template - ###.#####
        'Transmit Frequency',               // Template - ###.#####
        'Channel Type',                     // Template - A-Analog or D-Digital
        'Transmit Power',                   // Template - Low, Medium, High, or Turbo
        'Band Width',                       // Template - 12.5K or 25K
        'CTCSS/DCS Decode',                 // Template - ctcss array of frequencies
        'CTCSS/DCS Encode',                 // Template - ctcss array of frequencies
        'Contact',                          // Template - Talk Group name (need to check against imported talk groups)
        'Busy channel Lock-Out/TX Permit',  // Template - If Channel Type=A-Analog: Busy Channel Lock-Out = Off, Repeater, Busy (Default: Off)
                                            //            If Channel Type=D-Digital: TX-Permit = Always, ChannelFree, Different Color Code, Same Color Code (Default: Always)
        'Squelch Mode',                     // Template - If Channel Type=A-Analog AND CTCSS/DCS Decode<>Off: Carrier, CTCSS/DCS (Default: Carrier)
        'Color Code',                       // Template - If Channel Type=D-Digigal: Array 0-15 (Default: 1)
        'Slot',                             // Template - If Channel Type=D-Digital: Slot1 or Slot2 (Default: Slot1)
        'Receive Group List',               // Template - Sets Receive group list to generate with this entry (Default: None)
        'Scan List 1',                      // Template - Sets scan list(s) to generate with this entry (*Limited to 16 characters) (Default: NULL)
        'Scan List 2',                      // Template - Default: NULL
        'Scan List 3',                      // Template - Default: NULL
        'Scan List 4',                      // Template - Default: NULL
        'Scan List 5',                      // Template - Default: NULL
        'Scan List 6',                      // Template - Default: NULL
        'Scan List 7',                      // Template - Default: NULL
        'Scan List 8',                      // Template - Default: NULL
        'Exclude Channel From Roaming',     // Template - Off or On (Default: Off)
        'APRS Report Channel',              // Template - Array 1-8 (Default: 1)
        'Zone Channel List'                 // Template - *Custom Field, Sets Zone List Membership (*Limited to 16 characters, Limited to 250 entries per zone)
    ];

    $template_records = [
        [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25],
        ['Channel Name',                    // 1. Template - Name of channel (*Limited to 16 characters, Limited to 4,000 entries)
        'Receive Frequency',                // 2. Template - ###.#####
        'Transmit Frequency',               // 3. Template - ###.#####
        'Channel Type',                     // 4. Template - A-Analog or D-Digital
        'Transmit Power',                   // 5. Template - Low, Medium, High, or Turbo
        'Band Width',                       // 6. Template - 12.5K or 25K
        'CTCSS/DCS Decode',                 // 7. Template - ctcss array of frequencies
        'CTCSS/DCS Encode',                 // 8. Template - ctcss array of frequencies
        'Contact',                          // 9. Template - Talk Group name (need to check against imported talk groups)
        'Busy channel Lock-Out/TX Permit',  // 10. Template - If Channel Type=A-Analog: Busy Channel Lock-Out = Off, Repeater, Busy (Default: Off)
                                            //            If Channel Type=D-Digital: TX-Permit = Always, ChannelFree, Different Color Code, Same Color Code (Default: Always)
        'Squelch Mode',                     // 11. Template - If Channel Type=A-Analog AND CTCSS/DCS Decode<>Off: Carrier, CTCSS/DCS (Default: Carrier)
        'Color Code',                       // 12. Template - If Channel Type=D-Digigal: Array 0-15 (Default: 1)
        'Slot',                             // 13. Template - If Channel Type=D-Digital: Slot1 or Slot2 (Default: Slot1)
        'Receive Group List',               // 14. Template - Sets Receive group list to generate with this entry (Default: None)
        'Scan List 1',                      // 15. Template - Sets scan list(s) to generate with this entry (*Limited to 16 characters) (Default: NULL)
        'Scan List 2',                      // 16. Template - Default: NULL
        'Scan List 3',                      // 17. Template - Default: NULL
        'Scan List 4',                      // 18. Template - Default: NULL
        'Scan List 5',                      // 19. Template - Default: NULL
        'Scan List 6',                      // 20. Template - Default: NULL
        'Scan List 7',                      // 21. Template - Default: NULL
        'Scan List 8',                      // 22. Template - Default: NULL
        'Exclude Channel From Roaming',     // 23. Template - Off or On (Default: Off)
        'APRS Report Channel',              // 24. Template - Array 1-8 (Default: 1)
        'Zone Channel List'                 // 25. Template - *Custom Field, Sets Zone List Membership (*Limited to 16 characters, Limited to 250 entries per zone)
        ]
    ];

    # Build Template File
    $template_csv = Writer::createFromString();     //load the template CSV document from a string
    $template_csv->insertOne($template_header);     //insert the template header
    $template_csv->insertAll($template_records);    //insert the initial template records
    echo $template_csv->toString();                 //returns the CSV document as a string
}


## Get Channel List from User Upload
function getChannelRecords() {
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
        'TX Prohibit',                      // Off, On (Default: Off)
        'Reverse',                          // Off, On (Default: Off)
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
        'Random Key'                        // 0, 1 (Default: 0)
    ];

    # Channel List Records Population
    for($i=0;$i<sizeof($uploaded_records);$i++){
        for($j=0;$j<50;$j++){
            $uploaded_records[i][j];
        }
    }

    # Channel List Records
    $channel_list_records = [
        [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50],
        [$channel_num,          // 1. Channel Number
        $channel_name,          // 2. Channel Name
        $rx_frequency,          // 3. RX Frequency
        $tx_frequency,          // 4. TX Frequency
        $channel_type,          // 5. Channel Type - 'A-Analog' OR 'D-Digital'
        $transmit_power,        // 6. Transmit Power Level
        $band_width,            // 7. Bandwidth (kHz)
        $ctcss_decode,          // 8. CTCSS Decode Tone (Hz)
        $ctcss_encode,          // 9. CTCSS Encode Tone (Hz)
        $talkgroup_name,        // 10. Contact Name or Talk Group Name
        $contact_call_type,     // 11. Contact Call Type - 'Private Call' OR 'Group Call'
        $radio_id,              // 12. Radio ID
        $txpermit,              // 13. Busy Channel Lock Out/TX Permit - A-Analog='Off' OR D-Digital='Always'
        $squelch_mode,          // 14. Squelch Mode - 'Carrier' OR 'CTCSS/DCS'
        'Off',                  // 15. Optional Signal
        'NULL',                 // 16. DTMF ID
        '1',                    // 17. 2Tone ID
        '1',                    // 18. 5Tone ID
        'Off',                  // 19. PTT ID
        $color_code,            // 20. Digital Color Code - '1'
        $slot,                  // 21. Digital Slot - 'Slot1'
        $receive_group_list,    // 22. Receive Group List membership - 'None'
        'Off',                  // 23. TX Prohibit
        'Off',                  // 24. Reverse
        'Off',                  // 25. Simplex TDMA
        'Off',                  // 26. TDMA Adaptive
        'Normal Encryption',    // 27. Encryption Type
        'Off',                  // 28. Digital Encryption
        'Off',                  // 29. Call Confirmation
        'Off',                  // 30. Talk Around
        'Off',                  // 31. Work Alone
        '251.1',                // 32. Custom CTCSS tone
        '1',                    // 33. 2Tone Decode
        '1',                    // 34. DTMF Own ID
        '1',                    // 35. 5Tone Own ID
        $scan_list_1,           // 36. Scan List 1 membership
        $scan_list_2,           // 37. Scan List 2 membership
        $scan_list_3,           // 38. Scan List 3 membership
        $scan_list_4,           // 39. Scan List 4 membership
        $scan_list_5,           // 40. Scan List 5 membership
        $scan_list_6,           // 41. Scan List 6 membership
        $scan_list_7,           // 42. Scan List 7 membership
        $scan_list_8,           // 43. Scan List 8 membership
        'Off',                  // 44. Ranging
        'Off',                  // 45. Through Mode
        'Off',                  // 46. Exclude Channel From Roaming
        '1',                    // 47. APRS Report Channel
        '0',                    // 48. AES Digital Encryption
        '0',                    // 49. Multi-Key
        '0'                     // 50. Random Key
        ]
    ];

    # Build Channel List File
    $csv = Writer::createFromString();  //load the CSV document from a string
    $csv->insertOne($header);           //insert the header
    $csv->insertAll($records);          //insert all the records
    echo $csv->toString();              //returns the CSV document as a string
}


## Build Zone List File
function buildZoneList() {
    # Zone List Headers
    $zone_list_header = [
        'No.',
        'Zone Name',            // Name of zone list, set from scan list names in channel list (*Limited to 16 characters)
        'Zone Channel Member',  // '|' Separated channel list names, aggregated from zone list fields in channel list (*Limited to 250 entries per zone)
        'A Channel',            // Default to channel 1 in Zone Channel Members list
        'B Channel'             // Default to channel 2 in Zone Channel Membners list
    ];

    # Zone List Records
    $zone_list_records = [
        [1, 2, 3, 4, 5],
        [$zone_number,          // 1. Zone Number
        $zone_list_name,        // 2. Zone List Name
        $zone_channel_members,  // 3. Zone Channel Members
        $zone_channelA,         // 4. Zone Channel A
        $zone_channelB          // 5. Zone Channel B
        ]
    ];

    # Build Zone List File
    $csv = Writer::createFromString();  //load the CSV document from a string
    $csv->insertOne($header);           //insert the header
    $csv->insertAll($records);          //insert all the records
    echo $csv->toString();              //returns the CSV document as a string
}


## Build Scan List File
function buildScanList() {
    # Scan List Headers
    $scan_list_header = [
        'No.',
        'Scan List Name',           // Name of scan list, set from scan list names in channel list (*Limited to 16 characters)
        'Scan Channel Member',      // '|' Separated channel list names, aggregated from non-null scan list fields in channel list (*Limited to 50 entries per scan list)
        'Scan Mode',                // On, Off (Default: Off)
        'Priority Channel Select',  // Priority Channel Select1, Priority Channel Select2, Priority Channel Select1 + Priority Channel Select2 (Default: Off)
        'Priority Channel 1',       // Selected from Scan Channel Member list (Default: Off)
        'Priority Channel 2',       // Selected from Scan Channel Member list (Default: Off)
        'Revert Channel',           // Selected, Selected + TalkBack, Priority Channel Select1, Priority Channel Select2, Last Called, Last Used, Priority Channel Select1 + TalkBack, Priority Channel Select2 + TalkBack, set to Selected + TalkBack (Default: Selected) 
        'Look Back Time A[s]',      // 0.5-5.0 (.1 increments) (Default: 1.5)
        'Look Back Time B[s]',      // 0.5-5.0 (.1 increments) (Default: 2.5)
        'Dropout Delay Time[s]',    // 0.1-5.0 (.1 increments) (Default: 2.9)
        'Dwell Time[s]'             // 0.1-5.0 (.1 increments) (Default: 2.9)
    ];

    # Scan List Records
    $scan_list_records = [
        [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
        [$scan_list_number,     // 1. Scan List Number
        $scan_list_name,        // 2. Scan List Name
        $scan_channel_members,  // 3. Scan Channel Members
        'Off',                  // 4. Scan Mode
        'Off',                  // 5. Priority Channel Select
        'Off',                  // 6. Priority Channel 1
        'Off',                  // 7. Priority Channel 2
        'Selected + TalkBack',  // 8. Revert Channel
        '1.5',                  // 9. Look Back Time A
        '2.5',                  // 10. Look Back Time B
        '2.9',                  // 11. Dropout Delay Time
        '2.9'                   // 12. Dwell Time
        ]
    ];

    # Build Scan List File
    $csv = Writer::createFromString();  //load the CSV document from a string
    $csv->insertOne($header);           //insert the header
    $csv->insertAll($records);          //insert all the records
    echo $csv->toString();              //returns the CSV document as a string
}


## Build Roaming Channel List File
function buildRoamingChannelList() {
    # Roaming Channel List Headers
    $roaming_channel_list_header = [
        'No.',
        'Receive Frequency',    // ###.#####
        'Transmit Frequency',   // ###.#####
        'Color Code',           // Array 0-15 (Default: 1)
        'Slot',                 // Slot1 or Slot2 (Default: Slot1)
        'Name'                  // Zone list to generate with this entry (*Limited to 16 characters)
    ];

    # Roaming Channel List Records
    $roaming_channel_list_records = [
        [1, 2, 3, 4, 5, 6],
        [$roaming_channel_number,   // 1. Roaming Channel Number
        $roaming_rx_frequency,      // 2. Roaming Channel Receiving Frequency
        $roaming_tx_frequency,      // 3. Roaming Channel Transmitting Frequency
        $roaming_color_code,        // 4. Roaming Channel Color Code
        $roaming_slot_num,          // 5. Roaming Channel Slot Number
        $roaming_channel_name       // 6. Roaming Channel Name
        ]
    ];

    # Build Roaming Channel List File
    $csv = Writer::createFromString();  //load the CSV document from a string
    $csv->insertOne($header);           //insert the header
    $csv->insertAll($records);          //insert all the records
    echo $csv->toString();              //returns the CSV document as a string
}


## Build Roaming Zoan List File
function buildRoamingZoneList() {
    # Roaming Zone List Headers
    $roaming_zone_list_header = [
        'No.',
        'Zone Name',            // Name of zone list, set from Roaming Zone names in Roaming Channel List (*Limited to 16 characters)
        'Zone Channel Member',  // '|' Separated channel list names, aggregated from Roaming Zone List fields in Roaming Channel List (*Limited to 50 entries per roaming zone list)
        'A Channel',            // Default to channel 1 in Zone Channel Members list
        'B Channel'             // Default to channel 2 in Zone Channel Membners list
    ];

    # Roaming Zone List Recods
    $roaming_zone_list_records = [
        [1, 2, 3, 4, 5],
        [$roaming_zone_number,          // 1. Roaming Zone Number
        $roaming_zone_list_name,        // 2. Roaming Zone List Name
        $roaming_zone_channel_members,  // 3. Roaming Zone List Channel Members
        $roaming_zone_channelA,         // 4. Roaming Zone Channel A
        $roaming_zone_channelB          // 5. Roaming Zone Channel B
        ]
    ];

    # Build Roaming Zone List File
    $csv = Writer::createFromString();  //load the CSV document from a string
    $csv->insertOne($header);           //insert the header
    $csv->insertAll($records);          //insert all the records
    echo $csv->toString();              //returns the CSV document as a string
}


## Build Receive Group Call List File
function buildReceiveGroupList() {
    # Receive Group Call List Headers
    $receive_group_call_list_header= [
        'No.',
        'Group Name',   // Name of receive group, set from Receive Group 
        'Contact'       // '|' Separated contact list names, aggregated from Receive Group List fields in channel list (*Limited to 50 entries per receive list)
    ];

    # Receive Group Call List Records
    $receive_group_call_list_records = [
        [1, 2, 3],
        [$receive_group_number,         // 1. Receive Group Number
        $receive_group_name,            // 2. Receive Group Call List Name
        $receive_group_channel_members  // 3. Receive Group Call List Channel Members
        ]
    ];

    # Build Receive Group Call List File
    $csv = Writer::createFromString();  //load the CSV document from a string
    $csv->insertOne($header);           //insert the header
    $csv->insertAll($records);          //insert all the records
    echo $csv->toString();              //returns the CSV document as a string
}



# TODO Completed template file uploader

# TODO File check - value checks

# TODO Additional info gathering and clarifications (if necessary)

# TODO RadioID entry

# TODO CPS file generation


?>