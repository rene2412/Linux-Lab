<?php
session_start();
error_reporting(E_ALL & ~E_WARNING);
//require 'includes/config_session.inc.php';
require_once "includes/database.inc.php";
//session_unset();
require_once "network.php";
// Debugging: Log the request method and POST data
error_log("Request Method: " . $_SERVER['REQUEST_METHOD']);
error_log("POST Data: " . print_r($_POST, true));
// Add these headers at the top of the PHP script
header('Access-Control-Allow-Origin: *'); // Allow all origins (for development)
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

$fileSystem = [
    "/" => [
        "Documents" => [
            "directory" => [
                "permissions" => "drw-r--r--",
                "owner" => "user",
                "group" => "group",
                "created" => "2025-02-27 01:24:04",
                "modified" => "2025-02-27 01:24:04",
                "size" => 648,
            ],
            "Shakespeare.txt" => [
                "file" => [
                    "permissions" => "-rw-r--r--",
                    "owner" => "user",
                    "group" => "group",
                    "created" => "2025-02-27 01:24:04",
                    "modified" => "2025-02-27 01:24:04",
                    "size" => 648,
                    "content" => [
                        "Shall I compare thee to a summer's day?",
                        "Thou art more lovely and more temperate:",
                        "Rough winds do shake the darling buds of May",
                        "And summers lease hath all too short a date",
                        "Sometime too hot the eye of heaven shines",
                        "And often is his gold complexion dimm",
                        "And every fair from fair sometime declines",
                        "By chance or natures changing course untrimm",
                        "But thy eternal summer shall not fade,",
                        "Nor lose possession of that fair thou owst",
                        "Nor shall death brag thou wanderst in his shade",
                        "When in eternal lines to time thou growst",
                        "So long as men can breathe or eyes can see",
                        "So long lives this, and this gives life to thee."
                    ]      
                ]
            ],
            "Declaration.txt" => [
                "file" => [
                    "permissions" => "-rw-r--r--",
                    "owner" => "user",
                    "group" => "group",
                    "created" => "2025-02-28 01:24:04",
                    "modified" => "2025-02-28 01:24:04",
                    "size" => 3043,
                    "content" => [
"When, in the course of human events, it becomes necessary for one people to dissolve the political bands which have connected them with another,",
"and to assume, among the powers of the earth, the separate and equal station to which the laws of nature and of nature's God entitle them,",
"a decent respect to the opinions of mankind requires that they should declare the causes which impel them to the separation.",
"We hold these truths to be self-evident, that all men are created equal, that they are endowed, by their Creator, with certain unalienable rights,",
 "that among these are life, liberty, and the pursuit of happiness.",
"That to secure these rights, governments are instituted among men, deriving their just powers from the consent of the governed,",
"that whenever any form of government becomes destructive of these ends, it is the right of the people to alter or to abolish it,",
                        "and to institute new government, laying its foundation on such principles, and organizing its powers in such form,",
                        "as to them shall seem most likely to effect their safety and happiness.",
                        "Prudence, indeed, will dictate, that governments long established, should not be changed for light and transient causes;",
                        "and accordingly all experience hath shown, that mankind are more disposed to suffer, while evils are sufferable,",
                        "than to right themselves by abolishing the forms to which they are accustomed.",
                        "But when a long train of abuses and usurpations, pursuing invariably the same object,",
                        "evinces a design to reduce them under absolute despotism, it is their right, it is their duty,",
                        "to throw off such government, and to provide new guards for their future security.",
                        "Such has been the patient sufferance of these Colonies; and such is now the necessity which constrains them to alter their former systems of government.",
                        "The history of the present King of Great Britain is a history of repeated injuries and usurpations,",
                        "all having in direct object the establishment of an absolute tyranny over these States.",
                        "To prove this, let facts be submitted to a candid world.",
                        "He has refused his assent to laws, the most wholesome and necessary for the public good.",
                        "He has forbidden his governors to pass laws of immediate and pressing importance,",
                        "unless suspended in their operations till his assent should be obtained;",
                        "and when so suspended, he has utterly neglected to attend to them.",
                        "He has refused to pass other laws for the accommodation of large districts of people,",
                        "unless those people would relinquish the right of representation in the legislature,",
                        "a right inestimable to them, and formidable to tyrants only.",
                        "He has called together legislative bodies at places unusual, uncomfortable, and distant from the depository of their public records,",
                        "for the sole purpose of fatiguing them into compliance with his measures.",
                        "He has dissolved representative houses repeatedly, for opposing with manly firmness his invasions on the rights of the people.",
                        "He has refused for a long time, after such dissolutions, to cause others to be elected;",
                        "whereby the legislative powers, incapable of annihilation, have returned to the people at large for their exercise;",
                        "the State remaining, in the meantime, exposed to all the dangers of invasion from without, and convulsions within.",
                        "He has endeavored to prevent the population of these States;",
                        "for that purpose obstructing the laws for naturalization of foreigners;",
                        "refusing to pass others to encourage their migrations hither,",
                        "and raising the conditions of new appropriations of lands.",
                        "He has obstructed the administration of justice, by refusing his assent to laws for establishing judiciary powers.",
                        "He has made judges dependent on his will alone, for the tenure of their offices, and the amount and payment of their salaries.",
                        "He has erected a multitude of new offices, and sent hither swarms of officers to harass our people, and eat out their substance.",
                        "He has kept among us, in times of peace, standing armies, without the consent of our legislatures.",
                        "He has affected to render the military independent of and superior to the civil power.",
                        "He has combined with others to subject us to a jurisdiction foreign to our constitution, and unacknowledged by our laws;",
                        "giving his assent to their acts of pretended legislation:",
                        "For quartering large bodies of armed troops among us:",
                        "For protecting them, by a mock trial, from punishment for any murders which they should commit on the inhabitants of these States:",
                        "For cutting off our trade with all parts of the world:",
                        "For imposing taxes on us without our consent:",
                        "For depriving us, in many cases, of the benefits of trial by jury:",
                        "For transporting us beyond seas to be tried for pretended offences:",
                        "For abolishing the free system of English laws in a neighboring province,",
                        "establishing therein an arbitrary government,",
                        "and enlarging its boundaries, so as to render it at once an example and fit instrument for introducing the same absolute rule into these Colonies:",
                        "For taking away our charters, abolishing our most valuable laws, and altering fundamentally the forms of our governments:",
                        "For suspending our own legislatures, and declaring themselves invested with power to legislate for us in all cases whatsoever.",
                        "He has abdicated government here, by declaring us out of his protection, and waging war against us.",
                        "He has plundered our seas, ravaged our coasts, burnt our towns, and destroyed the lives of our people.",
                        "He is, at this time, transporting large armies of foreign mercenaries to complete the works of death, desolation, and tyranny,",
                        "already begun with circumstances of cruelty and perfidy, scarcely paralleled in the most barbarous ages, and totally unworthy the head of a civilized nation.",
                        "He has constrained our fellow-citizens, taken captive on the high seas, to bear arms against their country,",
                        "to become the executioners of their friends and brethren, or to fall themselves by their hands.",
                        "He has excited domestic insurrections amongst us,",
                        "and has endeavored to bring on the inhabitants of our frontiers, the merciless Indian savages,",
                        "whose known rule of warfare is an undistinguished destruction of all ages, sexes, and conditions.",
                        "In every stage of these oppressions we have petitioned for redress in the most humble terms:",
                        "our repeated petitions have been answered only by repeated injury.",
                        "A prince, whose character is thus marked by every act which may define a tyrant, is unfit to be the ruler of a free people.",
                        "Nor have we been wanting in attentions to our British brethren.",
                        "We have warned them, from time to time, of attempts by their legislature to extend an unwarrantable jurisdiction over us.",
                        "We have reminded them of the circumstances of our emigration and settlement here.",
                        "We have appealed to their native justice and magnanimity,",
                        "and we have conjured them by the ties of our common kindred to disavow these usurpations,",
                        "which would inevitably interrupt our connections and correspondence.",
                        "They, too, have been deaf to the voice of justice and of consanguinity.",
                        "We must, therefore, acquiesce in the necessity, which denounces our separation,",
                        "and hold them, as we hold the rest of mankind, enemies in war, in peace friends.",
                        "We, therefore, the Representatives of the United States of America, in General Congress assembled,",
                        "appealing to the Supreme Judge of the world for the rectitude of our intentions,",
                        "do, in the name, and by the authority of the good people of these Colonies,",
                        "solemnly publish and declare, that these United Colonies are, and of right ought to be, free and independent States;",
                        "that they are absolved from all allegiance to the British crown,",
                        "and that all political connection between them and the State of Great Britain is, and ought to be, totally dissolved;",
                        "And for the support of this declaration, with a firm reliance on the protection of Divine Providence,",
                        "we mutually pledge to each other our lives, our fortunes, and our sacred honour."
                        ]
                ]
            ],
        "Kennedy.txt" => [
            "file" => [
                "permissions" => "-rw-r--r--",
                "owner" => "user",
                "group" => "group",
                "created" => "2025-02-29 01:44:04",
                "modified" => "2025-02-29 01:54:04",
                "size" => 1040,
                "content" => [
  "President Pitzer, Mr. Vice President, Governor, Congressman Thomas, Senator Wiley, and Congressman Miller, Mr. Webb, Mr. Bell, scientists, distinguished guests, and ladies and gentlemen:",
  "I appreciate your president having made me an honorary visiting professor, and I will assure you that my first lecture will be very brief.",
  "I am delighted to be here, and I'm particularly delighted to be here on this occasion.",
  "We meet at a college noted for knowledge, in a city noted for progress, in a state noted for strength, and we stand in need of all three, for we meet in an hour of change and challenge, in a decade of hope and fear, in an age of both knowledge and ignorance. The greater our knowledge increases, the greater our ignorance unfolds.",
  "Despite the striking fact that most of the scientists that the world has ever known are alive and working today, despite the fact that this nation's own scientific manpower is doubling every 12 years in a rate of growth more than three times that of our population as a whole, despite that, the vast stretches of the unknown and the unanswered and the unfinished still far outstrip our collective comprehension.", 
  "No man can fully grasp how far and how fast we have come, but condense, if you will, the 50,000 years of man's recorded history in a time span of but a half-century. Stated in these terms, we know very little about the first 40 years, except at the end of them advanced man had learned to use the skins of animals to cover them. Then about 10 years ago, under this standard, man emerged from his caves to construct other kinds of shelter. Only five years ago man learned to write and use a cart with wheels. Christianity began less than two years ago. The printing press came this year, and then less than two months ago, during this whole 50-year span of human history, the steam engine provided a new source of power.", 
  "Newton explored the meaning of gravity. Last month electric lights and telephones and automobiles and airplanes became available. Only last week did we develop penicillin and television and nuclear power, and now if America's new spacecraft succeeds in reaching Venus, we will have literally reached the stars before midnight tonight.",
  "This is a breathtaking pace, and such a pace cannot help but create new ills as it dispels old, new ignorance, new problems, new dangers. Surely the opening vistas of space promise high costs and hardships, as well as high reward.", 
  "So it is not surprising that some would have us stay where we are a little longer to rest, to wait. But this city of Houston, this State of Texas, this country of the United States was not built by those who waited and rested and wished to look behind them. This country was conquered by those who moved forward — and so will space.", 
  "William Bradford, speaking in 1630 of the founding of the Plymouth Bay Colony, said that all great and honorable actions are accompanied with great difficulties, and both must be enterprised and overcome with answerable courage.", 
  "If this capsule history of our progress teaches us anything, it is that man, in his quest for knowledge and progress, is determined and cannot be deterred. The exploration of space will go ahead, whether we join in it or not, and it is one of the great adventures of all time, and no nation which expects to be the leader of other nations can expect to stay behind in the race for space.", 
  "Those who came before us made certain that this country rode the first waves of the industrial revolutions, the first waves of modern invention, and the first wave of nuclear power, and this generation does not intend to founder in the backwash of the coming age of space. We mean to be a part of it — we mean to lead it. For the eyes of the world now look into space, to the moon and to the planets beyond, and we have vowed that we shall not see it governed by a hostile flag of conquest, but by a banner of freedom and peace. We have vowed that we shall not see space filled with weapons of mass destruction, but with instruments of knowledge and understanding.",
  "Yet the vows of this nation can only be fulfilled if we in this nation are first, and, therefore, we intend to be first. In short, our leadership in science and in industry, our hopes for peace and security, our obligations to ourselves as well as others, all require us to make this effort, to solve these mysteries, to solve them for the good of all men, and to become the world's leading space-faring nation.",
  "We set sail on this new sea because there is new knowledge to be gained, and new rights to be won, and they must be won and used for the progress of all people. For space science, like nuclear science and all technology, has no conscience of its own. Whether it will become a force for good or ill depends on man, and only if the United States occupies a position of pre-eminence can we help decide whether this new ocean will be a sea of peace or a new terrifying theater of war. I do not say the we should or will go unprotected against the hostile misuse of space any more than we go unprotected against the hostile use of land or sea, but I do say that space can be explored and mastered without feeding the fires of war, without repeating the mistakes that man has made in extending his writ around this globe of ours.",
  "There is no strife, no prejudice, no national conflict in outer space as yet. Its hazards are hostile to us all. Its conquest deserves the best of all mankind, and its opportunity for peaceful cooperation may never come again. But why, some say, the moon? Why choose this as our goal? And they may well ask why climb the highest mountain? Why, 35 years ago, fly the Atlantic? Why does Rice play Texas?", 
  "We choose to go to the moon. We choose to go to the moon in this decade and do the other things, not because they are easy, but because they are hard, because that goal will serve to organize and measure the best of our energies and skills, because that challenge is one that we are willing to accept, one we are unwilling to postpone, and one which we intend to win, and the others, too.", 
  "It is for these reasons that I regard the decision last year to shift our efforts in space from low to high gear as among the most important decisions that will be made during my incumbency in the office of the presidency.", 
  "In the last 24 hours, we have seen facilities now being created for the greatest and most complex exploration in man's history. We have felt the ground shake and the air shattered by the testing of a Saturn C-1 booster rocket, many times as powerful as the Atlas which launched John Glenn, generating power equivalent to 10,000 automobiles with their accelerators on the floor. We have seen the site where five F-1 rocket engines, each one as powerful as all eight engines of the Saturn combined, will be clustered together to make the advanced Saturn missile, assembled in a new building to be built at Cape Canaveral as tall as a 48-story structure, as wide as a city block, and as long as two lengths of this field.",
  "Within these last 19 months at least 45 satellites have circled the earth. Some 40 of them were \"made in the United States of America,\" and they were far more sophisticated and supplied far more knowledge to the people of the world than those of the Soviet Union.",
  "The Mariner spacecraft now on its way to Venus is the most intricate instrument in the history of space science. The accuracy of that shot is comparable to firing a missile from Cape Canaveral and dropping it in this stadium between the 40-yard lines.",
  "Transit satellites are helping our ships at sea to steer a safer course. Tiros satellites have given us unprecedented warnings of hurricanes and storms, and will do the same for forest fires and icebergs.",
  "We have had our failures, but so have others, even if they do not admit them. And they may be less public.",
  "To be sure, we are behind, and will be behind for some time in manned flight. But we do not intend to stay behind, and in this decade, we shall make up and move ahead.",
  "The growth of our science and education will be enriched by new knowledge of our universe and environment, by new techniques of learning and mapping and observation, by new tools and computers for industry, medicine, the home as well as the school. Technical institutions, such as Rice, will reap the harvest of these gains.",
  "And finally, the space effort itself, while still in its infancy, has already created a great number of new companies, and tens of thousands of new jobs. Space and related industries are generating new demands in investment and skilled personnel, and this city and this state, and this region, will share greatly in this growth. What was once the furthest outpost on the old frontier of the West will be the furthest outpost on the new frontier of science and space. Houston, your city of Houston, with its Manned Spacecraft Center, will become the heart of a large scientific and engineering community. During the next five years the National Aeronautics and Space Administration expects to double the number of scientists and engineers in this area, to increase its outlays for salaries and expenses to $60 million a year; to invest some $200 million in plant and laboratory facilities; and to direct or contract for new space efforts over $1 billion from this center in this city.",
  "To be sure, all of this costs us all a good deal of money. This year's space budget is three times what it was in January 1961, and it is greater than the space budget of the previous eight years combined. That budget now stands at $5,400,000 a year — a staggering sum, though somewhat less than we pay for cigarettes and cigars every year. Space expenditures will soon rise some more, from 40 cents per person per week to more than 50 cents a week for every man, woman and child in the United States, for we have given this program a high national priority — even though I realize that this is in some measure an act of faith and vision, for we do not now know what benefits await us.", 
  "But if I were to say, my fellow citizens, that we shall send to the moon, 240,000 miles away from the control station in Houston, a giant rocket more than 300 feet tall, the length of this football field, made of new metal alloys, some of which have not yet been invented, capable of standing heat and stresses several times more than have ever been experienced, fitted together with a precision better than the finest watch, carrying all the equipment needed for propulsion, guidance, control, communications, food and survival, on an untried mission, to an unknown celestial body, and then return it safely to Earth, re-entering the atmosphere at speeds of over 25,000 miles per hour, causing heat about half that of the temperature of the sun — almost as hot as it is here today — and do all this, and do it right, and do it first before this decade is out — then we must be bold.", 
  "I'm the one who is doing all the work, so we just want you to stay cool for a minute. [laughter]",
  "However, I think we're going to do it, and I think that we must pay what needs to be paid. I don't think we ought to waste any money, but I think we ought to do the job. And this will be done in the decade of the sixties. It may be done while some of you are still here at school at this college and university. It will be done during the term of office of some of the people who sit here on this platform. But it will be done. And it will be done before the end of this decade.",
  "I am delighted that this university is playing a part in putting a man on the moon as part of a great national effort of the United States of America.",
  "Many years ago, the great British explorer George Mallory, who was to die on Mount Everest, was asked why did he want to climb it? He said, \"Because it is there.\"", 
  "Well, space is there, and we're going to climb it, and the moon and the planets are there, and new hopes for knowledge and peace are there. And, therefore, as we set sail we ask God's blessing on the most hazardous and dangerous and greatest adventure on which man has ever embarked.", 
  "Thank you."
               ]
            ]
        ],
            "penguin.txt" => [
                "file" => [
                    "permissions" => "-rw-r--r--",
                    "owner" => "user",
                    "group" => "group",
                    "created" => "2025-02-27 01:24:04",
                    "modified" => "2025-02-27 01:24:04",
                    "size" => 585,
                    "content" => [
                        "Penguins are cool"
                    ]
                ]
            ],
            "grocery_list.txt" => [
                "file" => [
                    "permissions" => "-rw-r--r--",
                    "owner" => "user",
                    "group" => "group",
                    "created" => "2025-02-27 01:24:04",
                    "modified" => "2025-02-27 01:24:04",
                    "size" => 285,
                    "content" => [
                        "Steak",
                        "Chicken",
                        "Rice",
                        "Spinach",
                        "Eggs",
                        "Potatoes",
                        "Bananaa",
                        "Apples",
                        "Strawberries",
                        "Carrorts",
                        "Spinach"
                    ]
                ]
            ],
            "hello.txt" => [
                "file" => [
                    "permissions" => "-rw-r--r--",
                    "owner" => "user",
                    "group" => "group",
                    "created" => "2025-02-27 01:24:04",
                    "modified" => "2025-02-27 01:24:04",
                    "size" => 148,
                    "content" => [
      "  ___                                      .-~. /_\"-._",
      "`-._~-.                                  / /_ \"~o\\  :Y",
      "      \\  \\                                / : \\~x.  ` ')",
      "      ]  Y                              /  |  Y< ~-.__j",
      "     /   !                        _.--~T : l  l<  /.-~",
      "    /   /                 ____.--~ .   ` l /~\\ \\<|Y",
      "   /   /             .-~~\"        /| .    ',-~\\ \\L| .... ROARRR!",
      "  /   /             /     .^   \\ Y~Y \\.^>/l_   \"--'",
      " /   Y           .-\"(  .  l__  j_j l_/ /~_.-~    .",
      "Y    l          /    \\  )    ~~~.\" / `/\"~ / \\.__/l_",
      "|     \\     _.-\"      ~-{__     l  :  l._Z~-.___.--~",
      "|      ~---~           /   ~~\"---\\_  ' __[>",
      "l  .                _.^   ___     _>-y~",
      " \\  \\     .      .-~   .-~   ~>--\"  /",
      "  \\  ~---\"            /     ./  _.-'",
      "   \"-.,_____.,_  _.--~\\     _.-~",
      "               ~~     (   _}  ",
      "                      `. ~(",
      "                        )  \\",
      "                  /,`--'~\\--'~\\",
                    ]
                ]
            ],
            "Lyrics" => [
                "LetItHappen.txt" => [
                    "file" => [
                        "permissions" => "-rw-r--r--",
                        "owner" => "user",
                        "group" => "group",
                        "created" => "2025-02-27 01:24:04",
                        "modified" => "2025-02-27 01:24:04",
                        "size" => 12,
                        "content" => [
                            "It's always around me, all this noise",
                            "But not nearly as loud as the voice saying",
                            "\"Let it happen, let it happen\" (it's gonna feel so good)",
                            "\"Just let it happen, let it happen\"",
                            "All this running around",
                            "Tryin' to cover my shadow",
                            "A notion growing inside",
                            "Now all the others seem shallow",
                            "All this running around",
                            "Bearing down on my shoulders",
                            "I can hear an alarm",
                            "Must be a morning",
                            "I heard about a whirlwind that's coming 'round",
                            "It's gonna carry off all that isn't bound",
                            "And when it happens, when it happens (I won't be holding on)",
                            "So let it happen, let it happen",
                            "All this running around",
                            "I can't fight it much longer",
                            "Something's tryin' to get out",
                            "And it's never been closer",
                            "If my take-off fails",
                            "Make up some other story",
                            "If I never come back",
                            "Tell my mother I'm sorry",
                            "I cannot vanish, you will not scare me",
                            "Try to get through it, try to push through it",
                            "You were not thinking that I will not do it",
                            "They be lovin' someone and I'm another story",
                            "Take the next ticket, get the next train",
                            "Why would I do it? Anyone'd think that",
                            "I cannot vanish, you will not scare me",
                            "Try to get through it, try to push through it",
                            "You were not thinking that I will not do it",
                            "They be lovin' someone and I'm another story",
                            "Take the next ticket, get the next train",
                            "Why would I do it? Anyone'd think that",
                            "Try to get through it, try to push through it",
                            "You were not thinking that I will not do it",
                            "They be lovin' someone and I'm another story",
                            "Take the next ticket, get the next train",
                            "Why would I do it? Anyone'd think that",
                            "Baby, now I'm ready, moving on",
                            "Oh, but maybe I was ready all along",
                            "Oh, I'm ready for the moment and the sound",
                            "Oh, but maybe I was ready all along",
                            "Baby, now I'm ready, moving on",
                            "Oh, but maybe I was ready all along",
                            "Oh, I'm ready for the moment and the sound",
                            "Oh, but maybe I was ready all along"
                        ]
                    ]
                ]
            ]
        ],
        "Pictures" => [
            "photo.jpg" => [
                "file.txt" => [
                    "permissions" => "-rw-r--r--",
                    "owner" => "user",
                    "group" => "group",
                    "created" => "2025-02-27 01:24:04",
                    "modified" => "2025-02-27 01:24:04",
                    "size" => 0,
                    "content" => []
                ]
            ]
        ],
        "Videos" => [],
        "Projects" => [
            "project1" => [],
            "file2.txt" => [
                "file" => [
                    "permissions" => "-rw-r--r--",
                    "owner" => "user",
                    "group" => "group",
                    "created" => "2025-02-27 01:24:04",
                    "modified" => "2025-02-27 01:24:04",
                    "size" => 0,
                    "content" => [ 
                    ]
                ]
            ]
        ],
        "Work" => [
            "daily_logs.txt" => [
                "file" => [
                    "permissions" => "--w-r--r--",
                    "owner" => "Steve",
                    "group" => "group",
                    "created" => "2025-03-24 01:24:04",
                    "modified" => "2025-03-25 04:04:04",
                    "size" => 15,
                    "content" => [
                        " [09:00] Opened store.",
                        "[09:15] Customer purchased 'Fender Stratocaster'.",
                        "[10:22] Inventory updated: +10 Guitar Strings (Ernie Ball 10-46).",
                        "[11:05] Customer asked about piano lesson availability.",
                        "[12:00] Lunch break.",
                        "[13:35] Sold: 'Yamaha P-125 Digital Piano'.",
                        "[14:20] Returned item: 'Boss DS-1 Distortion Pedal'.",
                        "[16:45] Stock check completed for drum kits.",
                        "[18:00] Closed store."
                    ]
                ]
            ],
            "sales_report.txt" => [
                "file" => [
                    "permissions" => "-rw-r--r--",
                    "owner" => "John",
                    "group" => "group",
                    "created" => "2025-02-20 01:24:04",
                    "modified" => "2025-02-27 01:24:04",
                    "size" => 44,
                    "content" => [ 
                    "Weekly Sales Report",
                    "Date Range: 2025-02-20 to 2025-02-27",
                    "---------------------------------------------",
                    "2025-02-20",
                    " - Sold: Gibson Les Paul Standard        - $2,499.00",
                    " - Sold: D'Addario Strings (3-pack)      - $29.97",
                    " - Sold: Roland TD-1DMK Drum Kit         - $699.99",
                    "",
                    "2025-02-21",
                    " - Sold: Taylor GS Mini Acoustic Guitar  - $599.00",
                    " - Sold: Shure SM58 Microphone           - $99.00",
                    " - Sold: Vox AC15 Amp                    - $749.00",
                    "",
                    "2025-02-22",
                    " - Sold: Fender Jazz Bass                - $899.00",
                    " - Sold: Drumsticks (Vic Firth 5A)       - $11.99",
                    " - Returned: Vox AC15 Amp                - -$749.00",
                    "",
                    "2025-02-23",
                    " - No sales (Store closed for maintenance)",
                    "",
                    "2025-02-24",
                    " - Sold: Casio CT-S1 Keyboard            - $199.00",
                    " - Sold: Audio-Technica AT2020 Mic       - $99.00",
                    " - Sold: XLR Cable (15ft)                - $19.99",
                    "",
                    "2025-02-25",
                    " - Sold: Ibanez RG450DX Electric Guitar  - $499.00",
                    " - Sold: Pedalboard Case (Gator)         - $89.00",
                    " - Sold: Boss RE-2 Space Echo Pedal      - $249.99",
                    "",
                    "2025-02-26",
                    " - Sold: Ludwig Breakbeats Drum Set      - $449.00",
                    " - Sold: Guitar Strap (Levy's)           - $29.99",
                    "",
                    "2025-02-27",
                    " - Sold: Yamaha P-125 Digital Piano      - $649.00",
                    " - Sold: Ernie Ball Strings (10pk)       - $69.90",
                    " - Returned: Boss DS-1 Distortion Pedal  - -$49.99",
                    "",
                    "---------------------------------------------",
                    "Notes:",
                    " - Increased sales in entry-level keyboards and microphones.",
                    " - Two returns processed: Vox AC15 Amp, Boss DS-1 Pedal.",
                    " - Drum kits and accessories performing steadily."
                    ]
                ]
            ],
        "revenue.py" => [
            "file" => [
                "permissions" => "-r--r--r--",
                "owner" => "John",
                "group" => "group",
                "created" => "2025-04-20 01:24:04",
                "modified" => "2025-04-21 00:24:04",
                "size" => 12,
                "content" => [ 
"sold = [2499.0, 29.97, 699.99, 599.0, 99.0, 749.0, 899.0, 11.99, 199.0, 99.0, 19.99, 499.0, 89.0, 249.99, 449.0, 29.99, 649.0, 69.9]
                
def totalSales(sold):
    result = 0
    for price in sold:
        result += price;
    return round(result, 2)
                
print(totalSales(sold))
"
                     ]
                 ]
             ]
         ]
     ]
];

if (!isset($_SESSION['fileSystem'])) {
    // Initialize new session with file system
    $_SESSION['fileSystem'] = $fileSystem;
    $_SESSION['currentDirectory'] = "/";
}
function process_echo(&$fileSystem, $currentDirectory, $arg, $operator, $file): string {
    if ( !empty($operator) && !in_array($operator, ['>', '>>'])) {
        return "Error: Invalid operator";
    }
   
    if (empty($operator) && empty($file)) {
        return $arg . "\n";
    } 

    if ($operator && $file) {
        $currentDirectory = rtrim($currentDirectory, "/");
        $pathParts = array_filter(explode("/", $currentDirectory), 'strlen');
        $currentLevel = &$fileSystem["/"];
        
        foreach ($pathParts as $part) {
            if (!isset($currentLevel[$part])) {
                return "Error: Invalid directory path.\n";
            }
            $currentLevel = &$currentLevel[$part];
        }
        if ($operator === '>' || $operator === '>>') {
            // Create the file if it doesn't exist using `touch`
            if (!isset($currentLevel[$file])) {
                $touchResult = process_touch($fileSystem, $currentDirectory, $file);
                if (str_starts_with($touchResult, "Error")) {
                    return $touchResult; // Propagate errors (e.g., invalid extension)
                }
            }
            // Check if target is a directory
            if (is_array($currentLevel[$file]) && !isset($currentLevel[$file]['file'])) {
                return "Error: '$file' is a directory.\n";
            }
            if (str_contains($file, "revenue.py")) {
                return "Error: Can't write into revenue.py";
            }
            // Update content (now guaranteed to be in array format)
            $fileContent = &$currentLevel[$file]['file']['content'];
            if ($operator === '>') {
                $fileContent = [$arg]; // Overwrite with new content
            } else { // >>
                $fileContent[] = $arg; // Append new line
            }
            
            // Update metadata
            $currentLevel[$file]['file']['modified'] = date("Y-m-d H:i:s");
            $contentString = implode("\n", $fileContent);
            $currentLevel[$file]['file']['size'] = strlen($contentString);
            
            $_SESSION['fileSystem'] = $fileSystem;
            return "";
        }
    }
    return $arg . "\n";
}

function process_ls($fileSystem, $currentDirectory): string {
    if ($currentDirectory === "/") {
        $currentLevel = $fileSystem["/"];
        return format_directory_contents($currentLevel);
    }
    $currentDirectory = rtrim($currentDirectory, "/");
    $path = array_filter(explode("/", $currentDirectory), 'strlen');
    $currentLevel = $fileSystem["/"];
    foreach ($path as $part) {
        if (!isset($currentLevel[$part])) {
             return "Directory not found.\n";
        }
        if (!is_array($currentLevel[$part])) {
            return "Not a directory.\n";
        }
        $currentLevel = $currentLevel[$part]; 
    }
    return format_directory_contents($currentLevel);
}

function format_directory_contents(array $contents): string {
    if (empty($contents)) {
        return "This directory is empty.\n";
    }
    $output = [];
    foreach ($contents as $name => $content) {
            if ($name === "directory") continue; //skip the directory meta data
            //if its an array that doesnt end with a .txt then its a directory
            if (is_array($content) && !str_ends_with($name, ".txt")  && !str_ends_with($name, ".py")) {
                $output[] = $name . "/";
            }
            else {
                $output[] = $name;
            }
        }
    sort($output);
    return implode(" ", $output) . "\n";
}

function process_touch(&$fileSystem, $currentDirectory, $arg) {   
    $GLOBALS['commandSuccess'] = false;
    if (!str_ends_with($arg, ".txt")) {
        return "Error: Files must end in .txt";
    }
    // Handle root directory special case 
    if ($currentDirectory === "/") {
        if (isset($fileSystem["/"][$arg])) {
            return "Error: '$arg' already exists\n";
        }
        // Create new file with metadata
        $fileSystem["/"][$arg] = [
            "file" => [
                "permissions" => "-rw-r--r--",
                "owner" => "user",
                "group" => "group",
                "created" => date("Y-m-d H:i:s"),
                "modified" => date("Y-m-d H:i:s"),
                "size" => 21,
                "content" => []
            ]
        ];
        $_SESSION['fileSystem'] = $fileSystem;
        $GLOBALS['commandSuccess'] = true;
        return "";
    }


    // Remove trailing slash if present
    $currentDirectory = rtrim($currentDirectory, "/");
    // Split path into components
    $path = array_filter(explode("/", $currentDirectory), 'strlen');
    // Start from root and maintain reference
    $currentLevel = &$fileSystem["/"];
    // Navigate to current directory
    foreach ($path as $part) {
        if (!isset($currentLevel[$part]) || $part === 'file' || !is_array($currentLevel[$part])) {
            return "Error: Directory not found\n";
        }
        $currentLevel = &$currentLevel[$part];
    }

    // Check if file already exists
    if (isset($currentLevel[$arg])) {
        return "Error: '$arg' already exists\n";
    }
 
    // Create new empty file with metadata
    $currentLevel[$arg] = [
        "file" => [
            "permissions" => "-rw-r--r--",
            "owner" => "user",
            "group" => "group",
            "created" => date("Y-m-d H:i:s"),
            "modified" => date("Y-m-d H:i:s"),
            "size" => 28,
            "content" => []
        ]
    ];
    
    // Make sure changes are saved to session
    $_SESSION['fileSystem'] = $fileSystem;
    $GLOBALS['commandSuccess'] = true; 
}

function process_ls_l($fileSystem, $currentDirectory) : string { 
    // Navigate to the target directory
    if ($currentDirectory === "/") {
        $currentLevel = $fileSystem["/"];
    } else {
        $currentDirectory = rtrim($currentDirectory, "/");
        $path = array_filter(explode("/", $currentDirectory), 'strlen');
        $currentLevel = $fileSystem["/"];
        foreach ($path as $part) {
            if (!isset($currentLevel[$part])) {
                return "Directory not found.\n";
            }
            $currentLevel = $currentLevel[$part];
        }
    }

    $output = "";
    foreach ($currentLevel as $name => $content) {
        // Files: Use metadata from 'file' key
        if (is_array($content) && isset($content['file'])) {
            $file = $content['file'];
            $line = sprintf(
                "%s %s %s %s %d %s\n",
                $file['permissions'],
                $file['owner'],
                $file['group'],
                $file['modified'],
                $file['size'],
                $name
            );
        } 
        // Directories: Default metadata
        else {
            $line = sprintf(
                "drw-r--r-- user group %s 4096 %s/\n",
                date("Y-m-d H:i:s"), // Placeholder timestamp
                $name
            );
        }
        $output .= $line;
    }
    return $output;
}

function process_cd(&$currentDirectory, $fileSystem, $dir): string {
    $GLOBALS['commandSuccess'] = false;
    // Handle root directory access: cd /
    if ($dir === "/") {
        $currentDirectory = "/";
        $GLOBALS['commandSuccess'] = true;
        return "";
    }

    // Convert relative path into an array
    $newPath = explode("/", trim($dir, "/"));
    $pathParts = explode("/", trim($currentDirectory, "/"));

    foreach ($newPath as $part) {
        if ($part === "..") {
            if (!empty($pathParts)) {
                array_pop($pathParts); // Move up one directory
            }
        } else {
            $pathParts[] = $part; // Move into the next directory
        }
    }

    // Resolve final path
    $resolvedPath = implode("/", $pathParts);
    if ($resolvedPath === "/") {
        $resolvedPath = "/";
    }

    // Traverse filesystem to validate the path
    $currentLevel = &$fileSystem["/"];
    $traversePath = array_filter(explode("/", trim($resolvedPath, "/")), 'strlen');

    foreach ($traversePath as $part) {
        if (str_ends_with($part, ".txt") || !isset($currentLevel[$part]) || !is_array($currentLevel[$part])) {
            return "Error: '$part' is not a directory.\n";
        }
        $currentLevel = &$currentLevel[$part];
    }

    // If successful, update current directory
    $currentDirectory = $resolvedPath;
    $GLOBALS['commandSuccess'] = true;
    return "";
}


// Ensure session start time is initialized correctly
if (!isset($_SESSION['start_time'])) {
    $_SESSION['start_time'] = time();
}

function process_pwd($currentDirectory) : string {
    return $currentDirectory;
}
function process_mkdir(&$fileSystem, $currentDirectory, $newdir): string {
    $GLOBALS['commandSuccess'] = false;
    // Remove any trailing slashes from the directory name
    $newdir = rtrim($newdir, "/");
    
    $special_chars = ['$', '~', '!', '@', '#', '%', '^', '&', '*', '(', ')', '-', '_', '+', '=', '|', '{', '}', ':', ';', '"', ',', '<', '>', '.', '?', '/', '\''];
    // Check if directory name is empty after removing slashes

    foreach($special_chars as $chars) {
        if (str_contains($newdir, $chars)) {
            return "Error: Special Characters Not Allowed To Make Directory";
        }
    }

    if (empty($newdir) || str_ends_with($newdir, ".txt")) {
        return "Invalid directory name\n";
    }
    
    // Traverse to the current directory in the file system
    $path = array_filter(explode("/", trim($currentDirectory, "/")), 'strlen');
    $currentLevel = &$fileSystem["/"]; // Start from root
    
    // Traverse the path to reach the current directory
    foreach ($path as $part) {
        if (!array_key_exists($part, $currentLevel)) {
            return "Error: Invalid Path\n";
        }
        $currentLevel = &$currentLevel[$part];
    }
    
    // Check if the directory already exists
    if (array_key_exists($newdir, $currentLevel)) {
        return "Error: directory already exists: $newdir\n";
    }
    
    // Create the new directory
    $currentLevel[$newdir] = [];
    $GLOBALS['commandSuccess'] = true;
    return "\n";
}

function process_cat(&$fileSystem, $dir, $file, $args, $targetFile) : string {
     // Handle root directory access: cd /
    if ($dir === "/") {
        $currentDirectory = "/";
        $GLOBALS['commandSuccess'] = true;
        return "";
    }

    // Convert relative path into an array
    $newPath = explode("/", trim($dir, "/"));
    $pathParts = explode("/", trim($currentDirectory, "/"));

    foreach ($newPath as $part) {
        if ($part === "..") {
            if (!empty($pathParts)) {
                array_pop($pathParts); // Move up one directory
            }
        } else {
            $pathParts[] = $part; // Move into the next directory
    }
}

    // Resolve final path
    $resolvedPath = implode("/", $pathParts);
    if ($resolvedPath === "/") {
        $resolvedPath = "/";
    }

// Traverse filesystem to validate the path
    $currentLevel = &$fileSystem["/"];
    $traversePath = array_filter(explode("/", trim($resolvedPath, "/")), 'strlen');

    foreach ($traversePath as $part) {
        if (str_ends_with($part, ".txt") || !isset($currentLevel[$part]) || !is_array($currentLevel[$part])) {
            return "Error: '$part' is not a directory.\n";
    }
        $currentLevel = &$currentLevel[$part];
    }

    // Check if file exists
    if (!isset($currentLevel[$file])) {
        return "Error: File not found.\n";
    }

    // Handle directories
    if (is_array($currentLevel[$file]) && !isset($currentLevel[$file]['file'])) {
        return "Error: '$file' is a directory.\n";
    }

    if ($args === '>' || $args === '>>') {
     //    $currentLevel = &$fileSystem["/"];
        // Create the file if it doesn't exist using `touch`
        if (!isset($currentLevel[$targetFile])) {
            $touchResult = process_touch($fileSystem, $currentDirectory, $targetFile);
            if (str_starts_with($touchResult, "Error")) {
                return $touchResult; // Propagate errors (e.g., invalid extension)
            }
        }
        
        // Check if target is a directory
        if (is_array($currentLevel[$targetFile]) && !isset($currentLevel[$targetFile]['file'])) {
            return "Error: '$targetFile' is a directory.\n";
        }

            $text = "";
            foreach ($currentLevel[$file]['file']['content'] as $lineNum => $lineText) {
                $words = explode(' ', $lineText); // Split line into words by spaces
                foreach ($words as $wordIndex => $word) {
                   $text .= $word . ' ';     
               }
                $text .= "\n";
            }
            if ($args == '>') {
                 // Write to target file
            $currentLevel[$targetFile]['file']['content'] = explode("\n", trim($text));
            }
         else { // >>
             // Append new content as lines
         $newLines = explode("\n", trim($text));
         $currentLevel[$targetFile]['file']['content'] = array_merge(
        $currentLevel[$targetFile]['file']['content'],
        $newLines
    );
 }
        
        // Update metadata
       // $currentLevel[$targetFile]['file']['modified'] = date("Y-m-d H:i:s");
        $contentString = implode("\n",  $currentLevel[$targetFile]['file']['content']);;
        $currentLevel[$targetFile]['file']['size'] = strlen($contentString);
        
        $_SESSION['fileSystem'] = $fileSystem;
        return "";
        }
    
    //its a regular cat command
    else {
    // Extract content based on format
    if (isset($currentLevel[$file]['file']['content'])) {
        $filePermissions = $currentLevel[$file]['file']['permissions'];
    if ($filePermissions[1] !== 'r') {
        return "Error: User does not have permission to read the file";
    }
      // New metadata format
      $GLOBALS['commandSuccess'] = true;
      return  implode("\n", $currentLevel[$file]['file']['content']) . "\n";
    } elseif (is_string($currentLevel[$file])) {
        // Legacy string format
        $GLOBALS['commandSuccess'] = true;
        return "String" . $currentLevel[$file] . "\n";
    }
}
    return "";
}

function traverse_to_current_directory($fileSystem, $currentDirectory, $dir) {
// Handle root directory access: 
if ($dir === "/") {
    $currentDirectory = "/";
    return "";
}  
// Convert relative path into an array
$newPath = explode("/", trim($dir, "/"));
$pathParts = explode("/", trim($currentDirectory, "/"));

foreach ($newPath as $part) {
    if ($part === "..") {
        if (!empty($pathParts)) {
            array_pop($pathParts); // Move up one directory
        }
    } else {
        $pathParts[] = $part; // Move into the next directory
    }
}

// Resolve final path
$resolvedPath = implode("/", $pathParts);
if ($resolvedPath === "/") {
    $resolvedPath = "/";
}

// Traverse filesystem to validate the path
$currentLevel = &$fileSystem["/"];
$traversePath = array_filter(explode("/", trim($resolvedPath, "/")), 'strlen');

foreach ($traversePath as $part) {
    if (str_ends_with($part, ".txt") || !isset($currentLevel[$part]) || !is_array($currentLevel[$part])) {
        return "Error: '$part' is not a directory.\n";
        }
    $currentLevel = &$currentLevel[$part];
    }
}

function process_copy(&$fileSystem, $currentDirectory, $file, $sourcePath): string {
    // Helper to resolve absolute paths
    $resolvePath = function ($baseDir, $path) {
        $isAbsolute = (substr($path, 0, 1) === '/');
        $parts = $isAbsolute ? [] : explode('/', trim($baseDir, '/'));
        foreach (explode('/', $path) as $part) {
            if ($part === '..') {
                if (!empty($parts)) array_pop($parts);
            } elseif ($part !== '.' && $part !== '') {
                $parts[] = $part;
            }
        }
        return '/' . implode('/', $parts);
    };

    // Resolve full source and target paths
    $sourceFullPath = $resolvePath($currentDirectory, $file);
    $targetFullPath = $resolvePath($currentDirectory, $sourcePath);

    // Navigate to source directory
    $sourceDir = dirname($sourceFullPath);
    $sourceName = basename($sourceFullPath);
    $sourceParts = array_filter(explode('/', trim($sourceDir, '/')), 'strlen');
    $sourceLevel = &$fileSystem['/'];
    foreach ($sourceParts as $part) {
        if (!array_key_exists($part, $sourceLevel) || !is_array($sourceLevel[$part])) {
            return "Error: Source path invalid.";
        }
        $sourceLevel = &$sourceLevel[$part];
    }

    // Check if source exists
    if (!array_key_exists($sourceName, $sourceLevel)) {
        return "Error: '$file' not found.";
    }

    // Navigate to target directory
    $targetDir = dirname($targetFullPath);
    $targetName = basename($targetFullPath);
    $targetParts = array_filter(explode('/', trim($targetDir, '/')), 'strlen');
    $targetLevel = &$fileSystem['/'];
    foreach ($targetParts as $part) {
        if (!array_key_exists($part, $targetLevel) || !is_array($targetLevel[$part])) {
            return "Error: Target directory does not exist.";
        }
        $targetLevel = &$targetLevel[$part];
    }

    // If target is a directory, append source name (e.g., cp file.txt dir/)
    if (array_key_exists($targetName, $targetLevel) && is_array($targetLevel[$targetName])) {
        $targetLevel = &$targetLevel[$targetName];
        $targetName = $sourceName;
    }

    // Check for conflicts
    if (array_key_exists($targetName, $targetLevel)) {
        return "Error: '$targetName' already exists.";
    }

    // Perform the copy (deep copy to avoid reference issues)
    $targetLevel[$targetName] = $sourceLevel[$sourceName];
  return "";
   // return "Successfully copied '$file' to '$sourcePath'.";
}

function process_mv(&$fileSystem, $currentDirectory, $oldname, $newname): string {
    // Helper to resolve absolute paths
    $resolvePath = function ($baseDir, $path) {
        $isAbsolute = (substr($path, 0, 1) === '/');
        $parts = $isAbsolute ? [] : explode('/', trim($baseDir, '/'));
        foreach (explode('/', $path) as $part) {
            if ($part === '..') {
                if (!empty($parts)) array_pop($parts);
            } elseif ($part !== '.' && $part !== '') {
                $parts[] = $part;
            }
        }
        return '/' . implode('/', $parts);
    };

    // Resolve full source and target paths
    $sourcePath = $resolvePath($currentDirectory, $oldname);
    $targetPath = $resolvePath($currentDirectory, $newname);

    // Navigate to source directory
    $sourceDir = dirname($sourcePath);
    $sourceName = basename($sourcePath);
    $sourceParts = array_filter(explode('/', trim($sourceDir, '/')), 'strlen');
    $sourceLevel = &$fileSystem['/'];
    foreach ($sourceParts as $part) {
        if (!array_key_exists($part, $sourceLevel) || !is_array($sourceLevel[$part])) {
            return "Error: Source path invalid.";
        }
        $sourceLevel = &$sourceLevel[$part];
    }

    // Check if source exists
    if (!array_key_exists($sourceName, $sourceLevel)) {
        return "Error: '$oldname' not found.";
    }

    // Navigate to target directory
    $targetDir = dirname($targetPath);
    $targetName = basename($targetPath);
    $targetParts = array_filter(explode('/', trim($targetDir, '/')), 'strlen');
    $targetLevel = &$fileSystem['/'];
    foreach ($targetParts as $part) {
        if (!array_key_exists($part, $targetLevel) || !is_array($targetLevel[$part])) {
            return "Error: Target directory does not exist.";
        }
        $targetLevel = &$targetLevel[$part];
    }

    // If target is a directory, append source name (e.g., mv file.txt dir/)
    if (array_key_exists($targetName, $targetLevel) && is_array($targetLevel[$targetName])) {
        $targetLevel = &$targetLevel[$targetName];
        $targetName = $sourceName;
    }

    // Check for conflicts
    if (array_key_exists($targetName, $targetLevel)) {
        return "Error: '$targetName' already exists.";
    }

    // Perform the move/rename
    $targetLevel[$targetName] = $sourceLevel[$sourceName];
    unset($sourceLevel[$sourceName]);
}

function process_refresh() : string {
    // Reinitialize session variables to restore the default file system
    global $fileSystem; // Access the original file system structure

    $_SESSION['fileSystem'] = unserialize(serialize($fileSystem)); // Reset the file system
    $_SESSION['currentDirectory'] = "/";  // Reset to root directory
     // Clear the session data
     session_unset();   // Unset all session variables
     session_destroy(); // Destroy the session
     session_start();
    return "File system has been reset to default.\n";
}

function process_rm(&$fileSystem, &$currentDirectory, $argument): string {
    $GLOBALS['commandSuccess'] = false;
    // Trim and split the current directory path
    $currentDirectory = rtrim($currentDirectory, "/");
    $path = array_filter(explode("/", $currentDirectory), 'strlen');
    $currentLevel = &$fileSystem["/"]; // Reference to root

    // Traverse to the current directory
    foreach ($path as $part) {
        if (!isset($currentLevel[$part]) || !is_array($currentLevel[$part])) {
            return "Error: '$part' not found.\n";
        }
        $currentLevel = &$currentLevel[$part]; // Maintain reference
    }

    // Check if the file exists
    if (!array_key_exists($argument, $currentLevel)) {
        return "Error: File '$argument' not found.\n";
    }

    // Check if the target is a directory
    if ((!str_ends_with($argument, ".txt"))) {
        return "Error: '$argument' is a directory. Use 'rmdir' to remove directories.\n";
    }

    // Remove the file
    unset($currentLevel[$argument]);
    $GLOBALS['commandSuccess'] = true;
}

function process_rmdir(&$fileSystem, &$currentDirectory, $argument): string {
    $GLOBALS['commandSuccess'] = false;
    // Prevent deleting parent directory with "rmdir .."
    if ($argument === "..") { 
        return "Error: Cannot remove parent directory.\n";
    }
    //ignore the arguement trail slash
    $argument = rtrim($argument, "/");
    // Trim and split the current directory path
    $currentDirectory = rtrim($currentDirectory, "/");
    $path = array_filter(explode("/", $currentDirectory), 'strlen');
    $currentLevel = &$fileSystem["/"]; // Reference to root

    // Traverse to the current directory
    foreach ($path as $part) {
        if (!isset($currentLevel[$part]) || !is_array($currentLevel[$part])) {
            return "Error: Directory '$part' not found.\n";
        }
        $currentLevel = &$currentLevel[$part]; // Maintain reference
    }

    // Check if the target directory exists
    if (!isset($currentLevel[$argument])) {
        return "Error: Directory '$argument' not found.\n";
    }

    // Check if it's actually a directory
    if (!is_array($currentLevel[$argument])) {
        return "Error: '$argument' is not a directory.\n";
    }

    // Check if the directory is empty before deleting
    if (!empty($currentLevel[$argument])) {
        return "Error: Directory '$argument' is not empty. Try 'rm -rf'\n";
    }

    // Otherwise remove the empty directory or file
    unset($currentLevel[$argument]);
    $GLOBALS['commandSuccess'] = true;
    return "'$argument' has been removed.\n";
}

function process_rm_rf(&$fileSystem, &$currentDirectory, $argument): string {
    // Prevent deleting parent directory with "rm -rf .."
    if ($argument === "..") {
        return "Error: Cannot remove parent directory.\n";
    }

    // Trim and split the current directory path
    $currentDirectory = rtrim($currentDirectory, "/");
    $path = array_filter(explode("/", $currentDirectory), 'strlen');
    $currentLevel = &$fileSystem["/"]; // Reference to root

    // Traverse to the current directory (without checking $argument yet)
    foreach ($path as $part) {
        if (!isset($currentLevel[$part]) || !is_array($currentLevel[$part])) {
            return "Error: Directory '$part' not found.\n";
        }
        $currentLevel = &$currentLevel[$part]; // Maintain reference
    }

    // Check if the target exists
    if (!isset($currentLevel[$argument])) {
        return "Error: '$argument' not found.\n";
    }

    // Recursively delete if it's a directory
    if (is_array($currentLevel[$argument])) {
        delete_recursive($currentLevel[$argument]); // recursively delete
    }

    // Remove the target (file or now-empty directory)
    unset($currentLevel[$argument]);

}

 // Helper function to recursively delete a directory's contents.
function delete_recursive(&$directory) {
    foreach ($directory as $key => &$content) {
        if (is_array($content)) {
            delete_recursive($content); // Recursive call for subdirectories
        }
        unset($directory[$key]); // Delete files or now-empty directories
    }
}


function octal_chmod(&$fileSystem, $currentDirectory, $permissions, $argument, ) : string {
    $perms = strval($argument);
    if (strlen($perms) > 3)  {
        return "Error: Invalid Chmod Command";
    }
    
    $map = [
        "0" => "---",
        "1" => "--x",
        "2" => "-w-",
        "3" => "-wx",
        "4" => "r--",
        "5" => "r-x",
        "6" => "rw-",
        "7" => "rwx"
    ];

  if (strlen($perms) === 1) {
             if (!is_numeric($perms) || $perms > 7 || $perms < 0) {
                     return "Error: Invalid Chmod Command\n";
             }
             $newOtherPerms =  $map[$perms];
             $userPerms = $permissions[1] . $permissions[2] . $permissions[3];
             $groupPerms = $permissions[4] . $permissions[5] . $permissions[6];
             return $permissions[0] . $userPerms . $groupPerms . $newOtherPerms;
    }
if (strlen($perms) === 2) {
        for ($i = 0; $i < 2; $i++) {
            if (!is_numeric($perms[$i]) || $perms[$i] > 7 || $perms[$i] < 0) {
                    return "Error: Invalid Chmod Command";
            }
     }
             $newGroupPerms = $map[$perms[0]];
             $newOtherPerms = $map[$perms[1]];
             $userPerms = $permissions[1] . $permissions[2] . $permissions[3];
           return $permissions[0] . $userPerms . $newGroupPerms . $newOtherPerms;
    }
else {
    for ($i = 0; $i < 3; $i++) {
            if ($perms[$i] > 7 || $perms[$i] < 0) {
                return "Error: Invalid Chmod Command";
            }
    }
    $userPerms = $perms[0]; 
    $groupPerms = $perms[1];
    $otherPerms = $perms[2];

    $permissions = $permissions[0] . $map[$userPerms] . $map[$groupPerms] . $map[$otherPerms];
    return $permissions;
    }  
}

function process_sort(&$fileSystem, $currentDirectory, $flags, $file) {
    $resolvePath = function ($baseDir, $path) {
        $isAbsolute = (substr($path, 0, 1) === '/');
        $parts = $isAbsolute ? [] : explode('/', trim($baseDir, '/'));
        foreach (explode('/', $path) as $part) {
            if ($part === '..') {
                if (!empty($parts)) array_pop($parts);
            } elseif ($part !== '.' && $part !== '') {
                $parts[] = $part;
            }
        }
        return '/' . implode('/', $parts);
    };

    if (empty($file)) {
        return "Error: No file specified.";
    }

    $filePath = $resolvePath($currentDirectory, $file);
    $fileDir = dirname($filePath);
    $fileName = basename($filePath);
    
    $fileParts = array_filter(explode('/', trim($fileDir, '/')), 'strlen');
    $fileLevel = &$fileSystem['/'];
    foreach ($fileParts as $part) {
        if (!array_key_exists($part, $fileLevel) || !is_array($fileLevel[$part])) {
            return "Error: Directory does not exist.";
        }
        $fileLevel = &$fileLevel[$part];
    }

   if (!array_key_exists($fileName, $fileLevel)) {
        return "Error: '$file' not found.";
    }
    
    if (is_array($fileLevel[$fileName]) && !isset($fileLevel[$fileName]['file'])) {
        return "Error: '$file' is a directory.";
    }

    if (isset($fileLevel[$fileName]['file']['permissions'])) {
        $filePermissions = $fileLevel[$fileName]['file']['permissions'];
        if ($filePermissions[1] !== 'r') {
            return "Error: User does not have permission to read the file";
        }
    }

    // Get file content - handle your file system structure
    if (isset($fileLevel[$fileName]['file']['content'])) {
        // Your file system stores content as array of lines
        $lines = $fileLevel[$fileName]['file']['content'];
    } elseif (is_string($fileLevel[$fileName])) {
        // Legacy string format fallback
        $content = $fileLevel[$fileName];
        $lines = explode("\n", $content);
    } else {
        return "Error: Unable to read file content.";
    }
    
    // Remove empty last line if it exists
    if (end($lines) === '') {
        array_pop($lines);
    }

    // Parse flags
    $reverse = false;
    $numeric = false;
    $unique = false;
    
    if (!empty($flags)) {
        $flagString = ltrim($flags, '-');
        $reverse = strpos($flagString, 'r') !== false;
        $numeric = strpos($flagString, 'n') !== false;
        $unique = strpos($flagString, 'u') !== false;
    }

    // Sort the lines
    if ($numeric) {
        // Numeric sort
        usort($lines, function($a, $b) use ($reverse) {
            $numA = is_numeric($a) ? (float)$a : 0;
            $numB = is_numeric($b) ? (float)$b : 0;
            $result = $numA <=> $numB;
            return $reverse ? -$result : $result;
        });
    } else {
        // Lexicographic sort
        if ($reverse) {
            rsort($lines);
        } else {
            sort($lines);
        }
    }

    // Remove duplicates if -u flag is used
    if ($unique) {
        $lines = array_unique($lines);
        $lines = array_values($lines); // Re-index array
    }

    return implode("\n", $lines);
}

   function process_chmod(&$fileSystem, $currentDirectory, $sudo, $argument, $targetFile) : string {
    
    // Navigate to the target directory
    $path = $currentDirectory === '/' ? [] : explode('/', trim($currentDirectory, '/'));
    $current = &$fileSystem['/'];
    foreach ($path as $part) {
        if (!isset($current[$part]) || !is_array($current[$part])) {
            return "Directory not found.\n";
        }
        $current = &$current[$part];
    }

    // Check if the target is a valid file (not a directory)
    if (
        !isset($current[$targetFile]) || 
        (is_array($current[$targetFile]) && !isset($current[$targetFile]['file']))
    ) {
        return "File not found or is a directory.\n";
    }

    // Update permissions (no need for legacy conversion; files use 'file' key)
    $file = &$current[$targetFile]['file'];
    $permissions = str_split($file['permissions']);
    $owner = $file['owner'];

    // Check permission to modify
    if ($owner !== "user" && $sudo !== "sudo") {
        return "Error: User does not own this file.\n";
    }

    if (is_numeric($argument)) {
            $octalPermissions = octal_chmod($fileSystem, $currentDirectory, $permissions, $argument);
            if (str_starts_with($octalPermissions, "Error:")) {
                return $octalPermissions; 
        }
        $file['permissions'] = $octalPermissions;
        $file['modified'] = date("Y-m-d H:i:s");
        return "Permissions updated for $targetFile.\n";
    }
    switch ($argument) {
        case '+x':
            $permissions[3] = 'x';
            $permissions[6] = 'x'; 
            $permissions[9] = 'x';
            break; 
        case '-x':
            $permissions[3] = '-'; 
            $permissions[6] = '-'; 
            $permissions[9] = '-'; 
            break;
        case '+r':
            $permissions[1] = 'r'; 
            $permissions[4] = 'r'; 
            $permissions[7] = 'r'; 
            break;
        case '-r':
            $permissions[1] = '-'; 
            $permissions[4] = '-'; 
            $permissions[7] = '-'; 
            break;  
        case '+w':
            $permissions[2] = 'w'; 
            $permissions[5] = 'w'; 
            $permissions[8] = 'w'; 
            break;
        case '-w':
            $permissions[2] = '-'; 
            $permissions[5] = '-'; 
            $permissions[8] = '-'; 
            break; 
        case 'u+x':
            $permissions[3] = 'x'; // User execute
            break;
        case 'u+r':
            $permissions[1] = 'r'; // User read
            break;
        case 'u-r':
            $permissions[1] = '-'; // Remove user read
            break;
        case 'g-w':
            $permissions[5] = '-'; // Remove group write
            break;
        case 'o=r':
            $permissions[7] = 'r'; // Others read
            $permissions[8] = '-'; // Others write
            $permissions[9] = '-'; // Others execute
            break;
        case 'g+x':
                $permissions[6] = 'x'; // Group execute
                break;
            
         case 'g+r':
                $permissions[4] = 'r'; // Group read
                break;
            
        case 'g+w':
                $permissions[5] = 'w'; // Group write
                break;
            
        case 'g-r':
                $permissions[4] = '-'; // Remove group read
                break;
        case 'g-x':
                $permissions[6] = '-'; // Remove group execute
                break;
            
        case 'o+x':
                $permissions[9] = 'x'; // Others execute
                break;
            
        case 'o+w':
                $permissions[8] = 'w'; // Others write
                break;
            
        case 'o-r':
                $permissions[7] = '-'; // Remove others read
                break;
            
        case 'o-w':
                $permissions[8] = '-'; // Remove others write
                break;
            
        case 'o-x':
                $permissions[9] = '-'; // Remove others execute
                break;
            
        case 'u-w':
                $permissions[2] = '-'; // Remove user write
                break;
            
            case 'u-x':
                $permissions[3] = '-'; // Remove user execute
                break;
            
            case 'a+r':
                $permissions[1] = 'r';
                $permissions[4] = 'r';
                $permissions[7] = 'r';
                break;
            
            case 'a-w':
                $permissions[2] = '-';
                $permissions[5] = '-';
                $permissions[8] = '-';
                break;
            
            case 'a+x':
                $permissions[3] = 'x';
                $permissions[6] = 'x';
                $permissions[9] = 'x';
                break;
            
            case 'a-r':
                $permissions[1] = '-';
                $permissions[4] = '-';
                $permissions[7] = '-';
                break;
        default:
            return "Error: Invalid Chmod Argument.\n";
    }
    $file['permissions'] = implode('', $permissions);
    $file['modified'] = date("Y-m-d H:i:s");
    return "";
}

function process_chown(&$fileSystem, $currentDirectory, $sudo, $newuser, $targetFile) : string {
     // Navigate to the target directory
     $path = $currentDirectory === '/' ? [] : explode('/', trim($currentDirectory, '/'));
     $current = &$fileSystem['/'];
     foreach ($path as $part) {
         if (!isset($current[$part]) || !is_array($current[$part])) {
             return "Directory not found.\n";
         }
         $current = &$current[$part];
     }
 
     // Check if the target is a valid file (not a directory)
     if (
         !isset($current[$targetFile]) || 
         (is_array($current[$targetFile]) && !isset($current[$targetFile]['file']))
     ) {
         return "File not found or is a directory.\n";
     }
 
     // Update permissions (no need for legacy conversion; files use 'file' key)
     $file = &$current[$targetFile]['file'];
     $owner = $file['owner'];
     //user does not have access to change it, must use sudo 
     if ($owner !== "user" && $sudo !== "sudo") {
        return "Error: User does not own this file";
     }
     //else user has permission or ran sudo
     $file['owner'] = $newuser;
     $file['modified'] = date("Y-m-d H:i:s");
     return "";
}


function retrieve_files_from_directory($fileSystem, $currentDirectory) : array {
	$files = []; // will hold all the files in current directory, the key will hold the file name and value will be its content
	 $currentDirectory = rtrim($currentDirectory, "/");
    	$pathParts = array_filter(explode("/", $currentDirectory), 'strlen');
    	$currentLevel = $fileSystem["/"];
	foreach ($pathParts as $part) {
        if (!isset($currentLevel[$part]) || !is_array($currentLevel[$part])) {
            return [];
        	}
        $currentLevel = $currentLevel[$part];
	}
	//for every thing in the current directory
	foreach($currentLevel as $name => $content) {
	//if the content is a directory, skip it
	if (!is_array($content)) {
		$files[$name] = $content;
		}
	}
	return $files;
}

function process_grep($fileSystem, $currentDirectory, $flag, $pattern, $file) : string {
    $currentDirectory = rtrim($currentDirectory, "/");
    $pathParts = array_filter(explode("/", $currentDirectory), 'strlen');
    $currentLevel = $fileSystem["/"];

    // Navigate to current directory
    foreach ($pathParts as $part) {
        if (!isset($currentLevel[$part]) || !is_array($currentLevel[$part])) {
            return "Error: Invalid directory path.\n";
        }
        $currentLevel = $currentLevel[$part];
    }

    $results = [];

    if ($file === "*.txt") {    
                $count = 0;
    foreach ($currentLevel as $name => $entry) {
            if (str_ends_with($name, ".txt") && isset($entry['file']['content'])) { 
                $lines = $entry['file']['content']; 
                
                foreach ($lines as $lineNum => $line) {
                    $line_numbers = $lineNum + 1;
                    $matches = false;
                    // Flag logic
                    if ($flag === "-w") {
                        // Whole word matching: use a regular expression for whole words
                        if (preg_match('/\b' . preg_quote($pattern, '/') . '\b/i', $line)) {
                            $results[] = $line;
                        }
                    }
                    elseif ($flag === "-n") {
                        if (strpos($line, $pattern) !== false) {
                            $results[] = "$name | Line: $line_numbers: $line";
                        }
                    } 
                    elseif ($flag === "-c") {
                        if (strpos($line, $pattern) !== false) $count++; 
                    }
                    elseif ($flag === "-i") {
                        if (stripos($line, $pattern) !== false) {
                            $results[] = $line;
                        }
                    }
                    else {
                        if (strpos($line, $pattern) !== false) {
                            $results[] = "$name: "  .  $line;
                        }
                    }
                }
            }
        }
    }
    
    else {
        if (!isset($currentLevel[$file])) {
            return "Error: File not found.\n";
        }
        if (!str_ends_with($file, ".txt") || !isset($currentLevel[$file]['file']['content'])) {
            return "Error: Not a .txt file.\n";
        }

        $lines = $currentLevel[$file]['file']['content'];
        $line_numbers = 0;
        $count = 0;
        foreach ($lines as $line) {
            $line_numbers++;
            // Flag logic
            if ($flag === "-n") {
                if (strpos($line, $pattern) !== false) {
                    $results[] = "Line: $line_numbers | $line";
                }
            }
            elseif ($flag === "-w") {
                // Whole word matching: use a regular expression for whole words
                if (preg_match('/\b' . preg_quote($pattern, '/') . '\b/i', $line)) {
                    $results[] = $line;
                }
            } 
             
            elseif ($flag === "-c") {
                if (strpos($line, $pattern) !== false)
                 $count++;
            }
            elseif ($flag === "-i") {
                if (stripos($line, $pattern) !== false) {
                    $results[] = $line;
                }
            }
            else {
                if (strpos($line, $pattern) !== false) {
                    $results[] = $line;
                }
            }
        }
    }

    // Return results
    if ($flag === "-c") return ($count > 0) ? "$count\n" : "0\n";
    return empty($results) ? "Error: No matches found\n" : implode("\n", $results) . "\n";
}


function retrieve_files_from_argument($fileSystem, $currentDirectory, $path, $expression): array {
    $files = [];
    // Handle absolute or relative path
    $searchPath = $path;
    if (!str_starts_with($path, '/')) {
        $searchPath = rtrim($currentDirectory, "/") . "/" . $path;
    }
    $searchPath = rtrim($searchPath, "/");
    
    // Navigate to search directory
    $pathParts = array_filter(explode("/", ltrim($searchPath, "/")), 'strlen');
    $currentLevel = $fileSystem["/"];
    foreach ($pathParts as $part) {
        if (!isset($currentLevel[$part])) {
            return [];
        }
        $currentLevel = $currentLevel[$part];
    }
    
    // Search through this directory
    foreach ($currentLevel as $name => $entry) {
        $fullPath = $searchPath . "/" . $name;
        
        // If the name matches our expression, add it regardless of type
        if (fnmatch($expression, $name)) {
            $files[] = $fullPath;
        }
        
        // If it's a directory, also search inside it recursively
        if (is_array($entry) && !isset($entry['file'])) {
            $subFiles = retrieve_files_from_argument($fileSystem, "", $fullPath, $expression);
            $files = array_merge($files, $subFiles);
        }
    }
    
    return $files;
}
function process_find($fileSystem, $currentDirectory, $path, $expression): string {
    $files = retrieve_files_from_argument($fileSystem, $currentDirectory, $path, $expression);
    return empty($files) ? "Error: No files found.\n" : implode("\n", $files) . "\n";
}
function process_ping($host) : string {
    if ($host != "google.com" && $host != "142.250.72.206") return "Invalid Ping Command: Try Host Name 'google.com'";
        $output = $GLOBALS['ping'];
        $lines = explode("\n", $output);
        $result = "";
        
        for ($i = 0; $i < count($lines); $i++) {
                $result .= $lines[$i] . "\n";
                flush();
        }
	return $result;
}

function process_ifconfig() : string {
    return $GLOBALS['ifconfig'] . "\n";
}

function process_traceroute($host) : string {
    if ($host != "google.com") return "Invalid traceroute Command: Try Host Name 'google.com'";
    $output = $GLOBALS['traceroute'];
    $lines = explode("\n", $output);
    $result = "";
    
    for ($i = 0; $i < count($lines); $i++) {
            $result .= $lines[$i] . "\n";
            flush();
    }
return $result;
}

function process_ip_route() : string {
    $output = $GLOBALS['ip_route'];
    return $output;
}

function process_nslookup($host) : string {
    if ($host != "google.com") return "Invalid nslookup Command: Try Host Name 'google.com'";
    return $GLOBALS['nslookup'];
}

function process_dig($host) : string {
    if ($host != "google.com") return "Invalid dig Command: Try Host Name 'google.com'";
    return $GLOBALS['dig'];
}

function process_host($host) : string {
    if ($host != "google.com") return "Invalid host Command: Try Host Name 'google.com'";
    return $GLOBALS['host'];
}

function process_curl($host) : string {
    if ($host !== "https://www.apple.com/" && $host !== "https://www.weather_api/") return "Invalid curl command: Try a valid host name";
    if ($host === "https://www.apple.com/") return $GLOBALS['curl']; 
    else return $GLOBALS['curl_api'];
}
function process_wget(&$fileSystem, $currentDirectory, $host) : string {
    if ($host != "http://example.com") {
        return "Invalid wget Command: Try Host Name 'http://example.com'";
    }
    
    // Create index.html using the touch function
    $result = process_touch($fileSystem, $currentDirectory, "index.html");
    
    // Check if the file was created successfully
    if (strpos($result, "Successfully") === false) {
        return $result; // Return the error message
    }
    
    // Now update the content of the file we just created
    $currentDirectory = rtrim($currentDirectory, "/");
    $pathParts = array_filter(explode("/", $currentDirectory), 'strlen');
    
    // Initialize current level at root
    if ($currentDirectory === "/" || empty($pathParts)) {
        $currentLevel = &$fileSystem["/"];
    } else {
        $currentLevel = &$fileSystem["/"];
        // Navigate to the current directory
        foreach ($pathParts as $part) {
            if (!isset($currentLevel[$part])) {
                return "Error: Directory not found\n";
            }
            $currentLevel = &$currentLevel[$part];
        }
    }
    
    // Update the file with the HTML content
    if (isset($currentLevel["index.html"]) && isset($currentLevel["index.html"]["file"])) {
        $currentLevel["index.html"]["file"]["content"] = $GLOBALS['index'];
        $currentLevel["index.html"]["file"]["size"] = strlen($GLOBALS['index']);
        $currentLevel["index.html"]["file"]["modified"] = date("Y-m-d H:i:s");
        
        // Save changes to session
        $_SESSION['fileSystem'] = $fileSystem;
        
        // Return wget output to show the download was successful
        return $GLOBALS['wget'];
    } else {
        return "Error: Failed to update index.html\n";
    }
}

function process_date() : string {
    return date('Y-m-d H:i:s');
}

function GetFilePermissions($fileSystem, $currentDirectory, $targetFile) : string {
    // Navigate to the target directory
    $path = $currentDirectory === '/' ? [] : explode('/', trim($currentDirectory, '/'));
    $current = &$fileSystem['/'];
    foreach ($path as $part) {
        if (!isset($current[$part]) || !is_array($current[$part])) {
            return "Directory not found.\n";
        }
        $current = &$current[$part];
    }

    // Check if the target is a valid file (not a directory)
    if (
        !isset($current[$targetFile]) || 
        (is_array($current[$targetFile]) && !isset($current[$targetFile]['file']))
    ) {
        return "File not found or is a directory.\n";
    }

    // Update permissions (no need for legacy conversion; files use 'file' key)
    $file = &$current[$targetFile]['file'];
    $permissions = str_split($file['permissions']); 
    return $permissions[3];
}

function GetCurrentLesson() : int {
    $jsonUser = file_get_contents('src/testAPI/userInfo.json');
    // Decode the JSON into a PHP array
    $userData = json_decode($jsonUser, true);
    $value = (int)$userData[0]['lesson'];
    return $value;
}

function process_wc(&$fileSystem, $currentDirectory, $flag, $file) {
        // Trim and split the current directory path
        $currentDirectory = rtrim($currentDirectory, "/");
        $path = array_filter(explode("/", $currentDirectory), 'strlen');
        $currentLevel = &$fileSystem["/"]; // Reference to root
    
        // Traverse to the current directory
        foreach ($path as $part) {
            if (!isset($currentLevel[$part]) || !is_array($currentLevel[$part])) {
                return "Error: '$part' not found.\n";
            }
            $currentLevel = &$currentLevel[$part]; // Maintain reference
        }
    
        if (is_array($currentLevel[$file]) && !isset($currentLevel[$file]['file'])) {
            return "Error: '$file' is a directory.\n";
        }

        if ($file === "*.txt") { 
            $line_count = 0;
            $word_count = 0;
            $char_count = 0;

            $fileName = [];
            $file_line_count = [];
            $file_word_count = [];
            $file_char_count = []; 
            
            
            foreach ($currentLevel as $name => $entry) {
                if (str_ends_with($name, ".txt") && isset($entry['file']['content'])) { 
                    $lines = $entry['file']['content'];
                    $fileName[] = $name;       
                    $individual_line_count = 0;
                    $individual_word_count = 0;
                    $individual_char_count = 0;
                    foreach ($lines as $line) {
                        $line_count += 1;
                        $word_count += str_word_count($line);
                        $char_count += strlen($line) + 1;
                        $individual_line_count += 1;  
                        $individual_word_count += str_word_count($line);
                        $individual_char_count += strlen($line) + 1;
                       }
                        $file_line_count[] = $individual_line_count;
                        $file_word_count[] = $individual_word_count;
                        $file_char_count[] = $individual_char_count;
                   }                    
            }
            if ($char_count > 0) $char_count--;
            
            if (empty($flag)) {
                $output = "";
                for ($i = 0; $i < count($fileName); $i++) {
                    $output .= "$file_line_count[$i]\t$file_word_count[$i]\t$file_char_count[$i]\t$fileName[$i]\n"; 
            }
            $output .= "$line_count\t$word_count\t$char_count\ttotal";
            return $output;
        }

            
                elseif ($flag === "-l") {
                    $output = "";
                    for ($i = 0; $i < count($fileName); $i++) {
                        $output .= "$file_line_count[$i] $fileName[$i]\n";
                }
                $output .= "$line_count total";
                return $output;
            }
                elseif ($flag === "-w") {
                    for ($i = 0; $i < count($fileName); $i++) {
                        $output .= "$file_word_count[$i] $fileName[$i]\n";
                    }
                    $output .= "$word_count total";
                    return $output;
            }
                elseif ($flag === "-c") {
                    for ($i = 0; $i < count($fileName); $i++) {
                        $output .= "$file_char_count[$i] $fileName[$i]\n";
                    }
                    $output .= "$char_count total"; 
                    return $output;
                }    
                else return "Error: Flag Is Not Supported";
    }
      
        // Check if the file exists
        if (!array_key_exists($file, $currentLevel)) {
            return "Error: File '$file' not found.\n";
        }

        $lines = $currentLevel[$file]['file']['content'];
        $line_count = 0;
        $word_count = 0;
        $char_count = 0;
        foreach($lines as $line) {
            $word_count += str_word_count($line);
            $char_count += strlen($line);
            $line_count++;
        }
        if (empty($flag)) return "$line_count $word_count $char_count $file";
        elseif ($flag === "-l") return "$line_count $file";
        elseif ($flag === "-w") return "$word_count $file";
        elseif ($flag === "-c") return "$char_count $file"; 
        else return "Error: Flag Is Not Supported";
    }

function update_mysql(PDO $pdo, int $userId, int $lessonId, int $nextLesson) : void {
        if ($userId === null) return;
        $stmt = $pdo->prepare("
            INSERT INTO user_progress (user_id, lesson_id, lessons_completed, current_lesson)
            VALUES (?, ?, 1, ?) 
            ON DUPLICATE KEY UPDATE 
            lessons_completed = CASE 
            WHEN lessons_completed = 0 THEN 1  -- Ensure it starts at 1
            WHEN current_lesson <> VALUES(current_lesson) THEN lessons_completed + 1  
            ELSE lessons_completed 
        END, 
        current_lesson = VALUES(current_lesson)  
        lesson_id = VALUES(lesson_id)
        ");
    try {
        $stmt->execute([$userId, $lessonId, $nextLesson]);
    } catch (PDOException $e) {
       error_log("SQL Error: " . $e->getMessage());
   }
}

function updateUserProgress($pdo, $userId, $lesson_id) : void {
    if ($userId === null) return;
    if (isset($_SESSION["user_username"]) && !empty($_SESSION["user_username"])) {
    // Check if the user already completed the lesson
    $checkSql = "
    SELECT COUNT(*) FROM user_lessons 
    WHERE user_id = :userId AND lesson_id = :lesson_id;
    ";
    $stmt = $pdo->prepare($checkSql);
    $stmt->execute([
        ':userId' => $userId,
        ':lesson_id' => $lesson_id
    ]);
    $exists = $stmt->fetchColumn();

    // If no record exists, insert it
    if ($exists == 0) {
        $insertSql = "
        INSERT INTO user_lessons (user_id, lesson_id) 
        VALUES (:userId, :lesson_id);
        ";
        $stmt = $pdo->prepare($insertSql);
        $stmt->execute([
            ':userId' => $userId,
            ':lesson_id' => $lesson_id
            ]);
        }
    }
    else return;
}
//api to send the user progress to the front, in json, 
//we will do that by getting all the lessons ids the current user has and sending those keys to json
function send_user_progress(PDO $pdo, int $userId) : array {
        $sql = "
        SELECT lesson_id FROM user_lessons WHERE user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
        $lessons = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return ["completed_lessons" => $lessons];
}

    function send_user_status(PDO $pdo, string $username) : int {
        if (empty($username)) return 0;
        $sql = "SELECT is_logged_in FROM users WHERE username = ?";
          $stmt = $pdo->prepare($sql); 
          $stmt->execute([$username]);
          $user_status = $stmt->fetchColumn(); // Fetch single value
          return 1;
  } 

 function send_current_lesson(PDO $pdo, int $userId) : string {
    if ($userId === null) return null;
    $stmt = $pdo->prepare("SELECT lessons_completed, current_lesson FROM user_progress WHERE user_id = ?");
    $stmt->execute([$userId]);
    $progress = $stmt->fetch(PDO::FETCH_ASSOC);
    $current_lesson = $progress ? $progress["current_lesson"] : "Not Started";
    return $current_lesson . "\n";
    }
 function GetMultChoiceAnswer($lesson_id) : string {
        $answer = "";
        $data = json_decode(file_get_contents("src/testAPI/lessons.json"), true);
    
        foreach ($data as $section => $lessons) {
             if ($section === "The Basics") {
                foreach ($lessons as $lesson) {
                    if (isset($lesson['id']) && $lesson['id'] === $lesson_id) {
                        if (isset($lesson['answer'])) {
                            $answer = $lesson['answer'];
                            }
                        break; 
                    }
                }
                break;
            }
        }
        return $answer;
    }

 function GetNetworkMultChoiceAnswer($lesson_id) : string {
        $answer = "";
        $data = json_decode(file_get_contents("src/testAPI/lessons.json"), true);
    
        foreach ($data as $section => $lessons) {
            if ($section === "Networking") {
                foreach ($lessons as $lesson) {
                    if (isset($lesson['id']) && $lesson['id'] === $lesson_id) {
                        if (isset($lesson['answer'])) {
                            return $lesson['answer'];
                        }
                   }
              }
          }
       }
        return $answer;
    }

    function network_update_mysql(PDO $pdo, int $userId, int $lessonId, int $nextLesson) : void {
    if ($userId === null) return;
    $stmt = $pdo->prepare("
        INSERT INTO network_user_progress (user_id, lesson_id, lessons_completed, current_lesson)
        VALUES (?, ?, 1, ?) 
        ON DUPLICATE KEY UPDATE 
        lessons_completed = CASE 
        WHEN lessons_completed = 0 THEN 1  -- Ensure it starts at 1
        WHEN lesson_id <> VALUES(lesson_id) THEN lessons_completed + 1 
        ELSE lessons_completed 
    END, 
    current_lesson = VALUES(current_lesson),
     lesson_id = VALUES(lesson_id) 
");
try {
    $stmt->execute([$userId, $lessonId, $nextLesson]);
} catch (PDOException $e) {
   error_log("SQL Error: " . $e->getMessage());
    }
}

function network_updateUserProgress($pdo, $userId, $lesson_id) : void {
if ($userId === null) return;
if (isset($_SESSION["user_username"]) && !empty($_SESSION["user_username"])) {
// Check if the user already completed the lesson
$checkSql = "
SELECT COUNT(*) FROM network_user_lessons 
WHERE user_id = :userId AND lesson_id = :lesson_id;
";
$stmt = $pdo->prepare($checkSql);
$stmt->execute([
    ':userId' => $userId,
    ':lesson_id' => $lesson_id
]);
$exists = $stmt->fetchColumn();

// If no record exists, insert it
if ($exists == 0) {
    $insertSql = "
    INSERT INTO network_user_lessons (user_id, lesson_id) 
    VALUES (:userId, :lesson_id);
    ";
    $stmt = $pdo->prepare($insertSql);
    $stmt->execute([
        ':userId' => $userId,
        ':lesson_id' => $lesson_id
        ]);
    }
}
else return;
}

function network_send_user_progress(PDO $pdo, int $userId) : array {
    $sql = "
    SELECT lesson_id FROM network_user_lessons WHERE user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId]);
    $lessons = $stmt->fetchAll(PDO::FETCH_COLUMN);
    return ["completed_lessons" => $lessons];
}

function network_send_current_lesson(PDO $pdo, int $userId) : string {
    if ($userId === null) return null;
    $stmt = $pdo->prepare("SELECT lessons_completed, current_lesson FROM network_user_progress WHERE user_id = ?");
    $stmt->execute([$userId]);
    $progress = $stmt->fetch(PDO::FETCH_ASSOC);
    $current_lesson = $progress ? $progress["current_lesson"] : "Not Started";
    return $current_lesson . "\n";
}
    
    function contains_number($string) {
        return preg_match('/\d/', $string) === 1;
    }
    
// Handle the command
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $command = trim($_POST['command'] ?? '');
    $lessonID = (int) trim($_POST['lessonId'] ?? '');
    $_SESSION['guestLessonId'] = $lessonID;
    //fetch the current module from the global session
    $module = $_SESSION["module"];
    error_log("Current Module: $module");

    // Improved argument parsing with quote handling
    preg_match_all('/"([^"]*)"|\'([^\']*)\'|(\S+)/', $command, $matches);
    $args = [];
    foreach ($matches[0] as $match) {
        // If the match contains URL special characters, preserve quotes
        if (strpos($match, '&') !== false || strpos($match, '?') !== false) {
            $args[] = $match; // Keep original quotes
        }
        else {
            $trimmed = trim($match, "'\"");
            if (!empty($trimmed)) {
                $args[] = $trimmed;
            }   
        }
    }

    // Get the raw POST data
    $json_answer = file_get_contents('php://input');
    // Decode the JSON into a PHP associative array
    $data_answer = json_decode($json_answer, true);

    // Now you can access it like a regular array
    $multi_answer = $data_answer['answer'];

    $fileSystem = &$_SESSION['fileSystem'];
    $currentDir = &$_SESSION['currentDirectory'];
    $sudo = false;
    $cmd = $args[0] ?? '';
    $arg = $args[1] ?? '';
    $arg2 = $args[2] ?? '';
    $arg3 = $args[3] ?? '';
    $output = "";
    $json = '';

    $isCorrect = false;
    $jsonString = file_get_contents('src/testAPI/lessons.json');
    $jsonData = json_decode($jsonString, true);
    // Check for JSON parsing errors
    if (json_last_error() !== JSON_ERROR_NONE) {
      $output = "JSON Error: " . json_last_error_msg();
    }
    $GLOBALS['commandSuccess'] = false;
//get the user and id global variables from the session array
if (isset($_SESSION["user_username"]) && !empty($_SESSION["user_username"])) {
    $username = $_SESSION["user_username"];
} 

if (isset($_SESSION["user_id"]) && !empty($_SESSION["user_id"])) {
    $userId = $_SESSION["user_id"]; 
 }

error_log("Lesson ID: $lessonID");
error_log("Answer: " . GetMultChoiceAnswer($lessonID));
 //multi-choice and mysql handshake (madness) 
if ($module === "basics") {
 if ($lessonID === 17 && GetMultChoiceAnswer($lessonID)  === "B") {
    if ($userId !== null) {
         update_mysql($pdo, $userId, 17, 18);
         updateUserProgress($pdo, $userId, 17);
    }
}
if ($lessonID === 18 && GetMultChoiceAnswer($lessonID)  === "C") {
    if ($userId) {
        update_mysql($pdo, $userId, 18, 19);
        updateUserProgress($pdo, $userId, 18);
    }
}

if ($lessonID === 19 && GetMultChoiceAnswer($lessonID)  === "D") {
    if ($userId !== null) {
        update_mysql($pdo, $userId, 19, 20);
        updateUserProgress($pdo, $userId, 19);
    }
}

if ($lessonID === 31 && GetMultChoiceAnswer($lessonID)  === "B") {
    if ($userId !== null) {
        update_mysql($pdo, $userId, 31, 32);
        updateUserProgress($pdo, $userId, 31);
    }
}

if ($lessonID === 32 && GetMultChoiceAnswer($lessonID)  === "B") {
    if ($userId !== null) {
        update_mysql($pdo, $userId, 32, 33);
        updateUserProgress($pdo, $userId, 32);
    }
}

if ($lessonID === 33 && GetMultChoiceAnswer($lessonID)  === "C") {
    if ($userId !== null) {
    update_mysql($pdo, $userId, 33, 34);
    updateUserProgress($pdo, $userId, 33);
    }
}

if ($lessonID === 34 && GetMultChoiceAnswer($lessonID)  === "B") {
    if ($userId !== null) {
    update_mysql($pdo, $userId, 34, 35);
    updateUserProgress($pdo, $userId, 34);
    }
}

if ($lessonID === 35 && GetMultChoiceAnswer($lessonID)  === "C") {
    if ($userId !== null) {
    update_mysql($pdo, $userId, 35, 36);
    updateUserProgress($pdo, $userId, 35);
    }
}

if ($lessonID === 51 && GetMultChoiceAnswer($lessonID)  === "B") {
    if ($userId !== null) {
    update_mysql($pdo, $userId, 51, 52);
    updateUserProgress($pdo, $userId, 51);
    }
}

if ($lessonID === 52 && GetMultChoiceAnswer($lessonID)  === "C") {
    if ($userId !== null) {
    update_mysql($pdo, $userId, 52, 53);
    updateUserProgress($pdo, $userId, 52);
    }
}

if ($lessonID === 53 && GetMultChoiceAnswer($lessonID)  === "C") {
    if ($userId !== null) {
        update_mysql($pdo, $userId, 53, 54);
        updateUserProgress($pdo, $userId, 53);
    }
}

if ($lessonID === 54 && GetMultChoiceAnswer($lessonID)  === "B") {
    if ($userId !== null) {
        update_mysql($pdo, $userId, 54, 55);
        updateUserProgress($pdo, $userId, 54);
    }
}

if ($lessonID === 55 && GetMultChoiceAnswer($lessonID)  === "C") {
    if ($userId !== null) {
        update_mysql($pdo, $userId, 55, 56);
        updateUserProgress($pdo, $userId, 55);
    }
}

if ($lessonID === 71 && GetMultChoiceAnswer($lessonID)  === "D") {
    if ($userId !== null) {
        update_mysql($pdo, $userId, 71, 72);
        updateUserProgress($pdo, $userId, 71);
    }
}

if ($lessonID === 72 && GetMultChoiceAnswer($lessonID)  === "D") {
   if ($userId !== null) {
        update_mysql($pdo, $userId, 72, 73);
        updateUserProgress($pdo, $userId, 72);
    }
}

if ($lessonID === 73 && GetMultChoiceAnswer($lessonID)  === "A") {
    if ($userId !== null) {
        update_mysql($pdo, $userId, 73, 74);
        updateUserProgress($pdo, $userId, 73);
    }
}

if ($lessonID === 74 && GetMultChoiceAnswer($lessonID)  === "C") {
    if ($userId != null) {
        update_mysql($pdo, $userId, 74, 75);
        updateUserProgress($pdo, $userId, 74);
    }
}
if ($lessonID === 75 && GetMultChoiceAnswer($lessonID)  === "C") {
    if ($userId !== null) {
    update_mysql($pdo, $userId, 75, 76);
    updateUserProgress($pdo, $userId, 75);
        }
    }
}

if ($module === "networking") {
    if ($lessonID === 6 && GetNetworkMultChoiceAnswer($lessonID) === 'A') {
    if ($userId) {
        network_update_mysql($pdo, $userId, 6, 7);
        network_updateUserProgress($pdo, $userId, 6);
    }
}

if ($lessonID === 7 && GetNetworkMultChoiceAnswer($lessonID) === 'A') {
    if ($userId) {
        network_update_mysql($pdo, $userId, 7, 8);
        network_updateUserProgress($pdo, $userId, 7);
        }
    }
    if ($lessonID === 8 && GetNetworkMultChoiceAnswer($lessonID) === 'D') {
        if ($userId) {
            network_update_mysql($pdo, $userId, 8, 9);
            network_updateUserProgress($pdo, $userId, 8);
        }
    }

    if ($lessonID === 14 && GetNetworkMultChoiceAnswer($lessonID) === 'C') {
        if ($userId) {
            network_update_mysql($pdo, $userId, 14, 15);
            network_updateUserProgress($pdo, $userId, 14);
        }
    }
    if ($lessonID === 15 && GetNetworkMultChoiceAnswer($lessonID) === 'A') {
        if ($userId) {
            network_update_mysql($pdo, $userId, 15, 16);
            network_updateUserProgress($pdo, $userId, 15);
        }
    }
    if ($lessonID === 16 && GetNetworkMultChoiceAnswer($lessonID) === 'D') {
        if ($userId) {
            network_update_mysql($pdo, $userId, 16, 17);
            network_updateUserProgress($pdo, $userId, 16);
        }
    }
    if ($lessonID === 17 && GetNetworkMultChoiceAnswer($lessonID) === 'B') {
        if ($userId) {
            network_update_mysql($pdo, $userId, 17, 18);
            network_updateUserProgress($pdo, $userId, 17);
        }
    }
    if ($lessonID === 23 && GetNetworkMultChoiceAnswer($lessonID) === 'A') {
        if ($userId) {
            network_update_mysql($pdo, $userId, 23, 24);
            network_updateUserProgress($pdo, $userId, 23);
        }
    }
    if ($lessonID === 24 && GetNetworkMultChoiceAnswer($lessonID) === 'C') {
        if ($userId) {
            network_update_mysql($pdo, $userId, 24, 25);
            network_updateUserProgress($pdo, $userId, 24);
        }
    }
    if ($lessonID === 25 && GetNetworkMultChoiceAnswer($lessonID) === 'A') {
        if ($userId) {
            network_update_mysql($pdo, $userId, 25, 26);
            network_updateUserProgress($pdo, $userId, 25);
        }
    }
    if ($lessonID === 35 && GetNetworkMultChoiceAnswer($lessonID) === 'B') {
        if ($userId) {
            network_update_mysql($pdo, $userId, 35, 36);
            network_updateUserProgress($pdo, $userId, 35);
        }
    }
    if ($lessonID === 36 && GetNetworkMultChoiceAnswer($lessonID) === 'C') {
        if ($userId) {
            network_update_mysql($pdo, $userId, 36, 37);
            network_updateUserProgress($pdo, $userId, 36);
        }
    }
   if ($lessonID === 37 && GetNetworkMultChoiceAnswer($lessonID) === 'A') {
    if ($userId) {
        network_update_mysql($pdo, $userId, 37, 38);
        network_updateUserProgress($pdo, $userId, 37);
        }
    }
    if ($lessonID === 38 && GetNetworkMultChoiceAnswer($lessonID) === 'B') {
        if ($userId) {
            network_update_mysql($pdo, $userId, 38, 39);
            network_updateUserProgress($pdo, $userId, 38);
        }
    }
    if ($lessonID === 39 && GetNetworkMultChoiceAnswer($lessonID) === 'C') {
        if ($userId) {
            network_update_mysql($pdo, $userId, 39, 40);
            network_updateUserProgress($pdo, $userId, 39);
        }
    }
    if ($lessonID === 40 && GetNetworkMultChoiceAnswer($lessonID) === 'C') {
        if ($userId) {
            network_update_mysql($pdo, $userId, 40, 41);
            network_updateUserProgress($pdo, $userId, 40);
        }
    }
      if ($lessonID === 41 && GetNetworkMultChoiceAnswer($lessonID) === 'C') {
        if ($userId) {
            network_update_mysql($pdo, $userId, 41, 42);
            network_updateUserProgress($pdo, $userId, 41);
        }
    }
    if ($lessonID === 50 && GetNetworkMultChoiceAnswer($lessonID) === 'B') {
        if ($userId) {
            network_update_mysql($pdo, $userId, 50, 51);
            network_updateUserProgress($pdo, $userId, 50);
        }
    }
    if ($lessonID === 51 && GetNetworkMultChoiceAnswer($lessonID) === 'D') {
        if ($userId) {
            network_update_mysql($pdo, $userId, 51, 52);
            network_updateUserProgress($pdo, $userId, 51);
        }
    }
    if ($lessonID === 52 && GetNetworkMultChoiceAnswer($lessonID) === 'B') {
        if ($userId) {
            network_update_mysql($pdo, $userId, 52, 53);
            network_updateUserProgress($pdo, $userId, 52);
        }
    }
    if ($lessonID === 53 && GetNetworkMultChoiceAnswer($lessonID) === 'C') {
        if ($userId) {
            network_update_mysql($pdo, $userId, 53, 54);
            network_updateUserProgress($pdo, $userId, 53);
        }
    }

}

 switch ($cmd) {
    case 'echo':
        $GetLine = "";
        $operator = "";
        $file = "";   
    // Process args to handle redirection
    if (count($args) > 4) {
        $output = "Erorr: Invalid echo command\n";
        break;
    }
    for ($i = 0; $i < count($args); $i++) {
        $word = $args[$i];
        if ($word === $cmd) continue;    
        // Check for redirection operators
        
        if ($word === '>' || $word === '>>') {
            $operator = $word;
            if (isset($args[$i + 1])) {
                $file = $args[$i + 1];
                    }
        break;  // Stop adding to GetLine once we hit operator
                }
            $GetLine .= $word . " ";
            }
            $GetLine = rtrim($GetLine);  // Remove trailing space
             $json = $jsonData['basics'][1]['answer'] . "\n";  // or [2], or find the correct index 
            $full_command = $cmd . " " . $GetLine;
            // Trim and normalize the strings before comparing
            $normalizedJson = trim($json);
           
    if (strtolower($normalizedJson) === strtolower($normalizedCommand)) {
            $jsonData['basics'][1]['completed'] = true;
            $updatedJsonString = json_encode($jsonData, JSON_PRETTY_PRINT);
            file_put_contents('src/testAPI/lessons.json', $updatedJsonString);
           if ($lessonID === 6  && ($GetLine === "Hello World!" || $Getline === "\"Hello World!\"" || $Getline === "'Hello World!'"))  {
                 $isCorrect = true;
            if ($userId !== null) {
            update_mysql($pdo, $userId, 6, 7);            
            updateUserProgress($pdo, $userId, 6);
              }
            }             
         }   
         $output = process_echo($fileSystem, $currentDir, $GetLine, $operator, $file);
         if ($lessonID === 49 && $GetLine === "I Love Linux!" && $operator === '>' && $file === "Shakespeare.txt") {
            $isCorrect = true;
            if ($userId !== null) {
            update_mysql($pdo, $userId, 49, 50);            
            updateUserProgress($pdo, $userId, 49);
            }
        }
         if ($lessonID === 50 && $GetLine === "Dinosaur!" && $operator === '>>' && $file === "Shakespeare.txt") {
            $isCorrect = true;
            if ($userId !== null) {
            update_mysql($pdo, $userId, 50, 51);            
            updateUserProgress($pdo, $userId, 50);
            }
        }
         if ($lessonID === 59 && $GetLine === "Earth, Moon, Sun" && $operator === '>>' && $file === "Copy.txt" && !str_starts_with($output, "Error")) {
            $isCorrect = true;
            if ($userId !== null) {
            update_mysql($pdo, $userId, 59, 60);            
            updateUserProgress($pdo, $userId, 59);
            }
        }
         break;
    case 'whoami':
        
        if ($userId === null) {
            $username = "guest";
        } 
        $output = $username;
        if ($lessonID === 8) {
            $isCorrect = true;
            if ($userId) {
                update_mysql($pdo, $userId, 8, 9);  
                updateUserProgress($pdo, $userId, 8);
            }
        }
        break;   
    case 'touch':
            if (count($args) > 2) {
                $output = "Error: Invalid touch command\n";
                break;
            }
            $output = process_touch($fileSystem, $currentDir, $arg);    
            $jsonData['File Navigation'][7]['completed'] = true;
             // Convert the updated data back to JSON
            $updatedJsonString = json_encode($jsonData, JSON_PRETTY_PRINT);
            // Write the updated JSON back to the file
            file_put_contents('src/testAPI/lessons.json', $updatedJsonString);
            chmod('src/testAPI/lessons.json', 0666);
            if ($lessonID === 21 && $GLOBALS['commandSuccess'] && $arg === "linux.txt") {
                $isCorrect = true;
                if ($userId !== null) {
                update_mysql($pdo, $userId, 21, 22);  
                updateUserProgress($pdo, $userId, 21);
            }
        }
        break;
    case 'ls':
        if ($arg === '-l') {
            if (count($args) > 2) {
                $output = "Error: Invalid ls -l command";
                break;
            }
            $output = process_ls_l($fileSystem, $currentDir);
            if ($lessonID === 62) {
                $isCorrect = true;
                if ($userId !== null) {
                update_mysql($pdo, $userId, 62, 63);  
                updateUserProgress($pdo, $userId, 62);
            }
        }
            break;
        }
        if (count($args) > 1) {
            $output = "Error: Invalid ls command";
            break;
        }    
        $jsonData['basics'][4]['completed'] = true;
         // Convert the updated data back to JSON
        $updatedJsonString = json_encode($jsonData, JSON_PRETTY_PRINT);
        // Write the updated JSON back to the file
        file_put_contents('src/testAPI/lessons.json', $updatedJsonString);          
        chmod('src/testAPI/lessons.json', 0666);
        if ($lessonID === 10) {
            $isCorrect = true;
            if ($userId !== null) {
            update_mysql($pdo, $userId, 10, 11); 
            updateUserProgress($pdo, $userId, 10);
           }
       }
        $output = process_ls($fileSystem, $currentDir);
        break;
    case 'cd':
        if  (count($args) > 2) {
            $output = "Error: Invalid cd command";
            break;
            }
             $output = process_cd($currentDir, $fileSystem, $arg);
        if ($arg === "..") {
             $jsonData['basics'][6]['completed'] = true;
             //Convert the updated data back to JSON
             $updatedJsonString = json_encode($jsonData, JSON_PRETTY_PRINT);
             //Write the updated JSON back to the file
             file_put_contents('src/testAPI/lessons.json', $updatedJsonString);
             chmod('src/testAPI/lessons.json', 0666); 
             if ($lessonID === 14) {
                $isCorrect = true;
                if ($userId !== null) {
                 updateUserProgress($pdo, $userId, 14);
                 update_mysql($pdo, $userId, 14, 15);
            }
        }
             break;
        } else {
            if ($GLOBALS['commandSuccess']) {
             // Convert the updated data back to JSON
             $updatedJsonString = json_encode($jsonData, JSON_PRETTY_PRINT);
             //Write the updated JSON back to the file
             file_put_contents('src/testAPI/lessons.json', $updatedJsonString);
             chmod('src/testAPI/lessons.json', 0666);
             $jsonData['basics'][5]['completed'] = true;
            if ($lessonID === 16  && ($arg === "../Projects/project1" ||  $arg === "../Projects/project1/")) {
                $isCorrect = true;
                if ($userId !== null) {
                update_mysql($pdo, $userId, 16, 17);
                updateUserProgress($pdo, $userId, 16);
                }
            }
            if ($lessonID === 11 && ($arg === "Documents" || $arg === "Documents/")) {
                $isCorrect = true;
                if ($userId !== null) {
                update_mysql($pdo, $userId, 11, 12);
                updateUserProgress($pdo, $userId, 11);
               }
            }
            }
        }
        break;
    case 'clear':
        if ($lessonID === 13) {
            $isCorrect = true;
            if ($userId) {
                update_mysql($pdo, $userId, 13, 14);
                updateUserProgress($pdo, $userId, 13);
            }
        }
        break;
    case 'date':
        if (count($args) > 1) {
            $output = "Error: Invalid date command";
            break;
        }
            if ($lessonID === 7){
                $isCorrect = true;
                if ($userId !== null) {
                update_mysql($pdo, $userId, 7, 8); 
                updateUserProgress($pdo, $userId, 7);
            }
        }
            $output  = process_date();
            break;
    case 'cat':
            if (count($args) > 4) {
                $output = "Error: Invalid cat command";
                break;
             }
             if ($lessonID === 8 && count($args) > 2) {
                $output = "Error: Invalid cat command"; 
                break;
            }
               $output = process_cat($fileSystem, $currentDir, $arg, $arg2, $arg3);
               //Convert the updated data back to JSON
               $updatedJsonString = json_encode($jsonData, JSON_PRETTY_PRINT);
               //Write the updated JSON back to the file
               file_put_contents('src/testAPI/lessons.json', $updatedJsonString);
               chmod('src/testAPI/lessons.json', 0666);

               if ($lessonID === 20 && $arg !== "/Documents/Lyrics/LetItHappen.txt") {
                $output = "For this lab, please use the absolute path!";
                break;
              } 
               if ($lessonID === 20 && $arg === "/Documents/Lyrics/LetItHappen.txt") {
                $isCorrect = true;
                if ($userId) {
                    update_mysql($pdo, $userId, 20, 21 ); 
                    updateUserProgress($pdo, $userId, 20);
                }
                break;
            } 
            if ($lessonID === 12 && $GLOBALS['commandSuccess'] && $arg === "hello.txt" ) {
                $isCorrect = true;
                if ($userId !== null) {
                update_mysql($pdo, $userId, 12, 13); 
                updateUserProgress($pdo, $userId, 12);
                }
                break;
            }
            if ($lessonID === 58 && $arg === "LetItHappen.txt" && ( $arg2 === ">" || $arg2 === ">>") && $arg3 === "copy.txt" && $GLOBALS['commandSuccess']) {
                $isCorrect = true;
                if ($userId !== null) {
                update_mysql($pdo, $userId, 58, 59);
                updateUserProgress($pdo, $userId, 58); 
                    }
                }
        break;
    case 'pwd':
             $jsonData['basics'][3]['completed'] = true;
             if (count($args) > 1) {
                $output = "Error: Invalid pwd command";
                break;
            }
            if ($lessonID === 9) {
                $isCorrect = true;
                if ($userId !== null) {
                     update_mysql($pdo, $userId, 9, 10); 
                    updateUserProgress($pdo, $userId, 10);
            }
        }
            $output = process_pwd($currentDir);
            break;
    case 'cp':
        $output = process_copy($fileSystem, $currentDir, $arg, $arg2);
        if ($lessonID == 29 && $arg === "hello.txt" && ($arg2 === "../Projects" || $arg2 === "/Projects") && !str_starts_with($output, "Error:")) {
            $isCorrect = true;
            if ($userId !== null) {
                update_mysql($pdo, $userId, 29, 30);
                updateUserProgress($pdo, $userId, 29);
            }
        }
        break;
    case 'mkdir':
        if (count($args) > 2) {
            $output = "Error: Invalid mkdir command";
            break;
        }
        $output = process_mkdir($fileSystem, $currentDir, $arg);
        if ($lessonID == 22 && $GLOBALS['commandSuccess'] && ($arg === "ubuntu/" || $arg === "ubuntu")) {
                $isCorrect = true;
                if ($userId !== null) {
                update_mysql($pdo, $userId, 22, 23);
                updateUserProgress($pdo, $userId, 22);
                }
            }
        break;
    case 'mv':
            if (count($args) > 3) {
                $output = "Error: Invalid mv command";
                break;
            }
            $output = process_mv($fileSystem, $currentDir, $arg, $arg2);
            $GetLine = $arg . $arg2;
          
            if ($lessonID === 26 && $arg === "file2.txt" && $arg2 === "kali.txt" && $GLOBALS['commandSuccess']) {
                $isCorrect = true;
                if ($userId !== null) {
                    update_mysql($pdo, $userId, 26, 27);            
                    updateUserProgress($pdo, $userId, 26);
                }
            } 
            if ($lessonID === 27 && $arg === "Documents/" && $arg2 === "Debian/" && $GLOBALS['commandSuccess']) {
                $isCorrect = true;
                if ($userId !== null) {
                    update_mysql($pdo, $userId, 27, 28);            
                    updateUserProgress($pdo, $userId, 27);
                }
            }  
            if ($lessonID === 28 && $arg === "hello.txt" && ($arg2 === "../Projects/" || $arg2 === "../Projects") && $GLOBALS['commandSuccess']) {
                $isCorrect = true;
                if ($userId !== null) {
                    update_mysql($pdo, $userId, 28, 28);            
                    updateUserProgress($pdo, $userId, 29);
                }
            } 
            if ($lessonID === 30 && ($arg === "Projects" || $args === "Projects/") && ($arg2 === "Documents/Subfolder/" || $arg2 === "Documents/Subfolder")) {
                $isCorrect = true;
                if ($userId !== null) {
                    update_mysql($pdo, $userId, 30, 31);            
                    updateUserProgress($pdo, $userId, 30);
                }
            }        
            break;
    
    case 'rm':
            if ($arg == "-rf") {
                if (count($args) > 3) {
                    $output = "Error: Invalid rm -rf command";
                    break;
                }
                $output = process_rm_rf($fileSystem, $currentDir, $arg2);
                if (str_starts_with($output, "Error:")) {
                    break;
                }
                if ($lessonID === 25 && ($arg2 === "Subfolder/" || $arg2 === "Subfolder")) {
                     $isCorrect = true;
                     if ($userId !== null) {
                         update_mysql($pdo, $userId, 25, 26);
                         updateUserProgress($pdo, $userId, 25);
                     }
                }
                if ($lessonID === 36 && ($arg2 === "School/" || $arg2 === "School")) {
                    $isCorrect = true;
                    if ($userId !== null) {
                        update_mysql($pdo, $userId, 36, 37);
                        updateUserProgress($pdo, $userId, 36);
                    }
               }
                break;
            } else {
                if (count($args) > 2) {
                    $output = "Error: Invalid rm command";
                    break;
                }
                $output = process_rm($fileSystem, $currentDir, $arg);
                if ($lessonID === 23 && $GLOBALS['commandSuccess'] && $arg === "penguin.txt") {
                    $isCorrect = true;
                    if ($userId !== null) {
                        update_mysql($pdo, $userId, 23, 24);
                        updateUserProgress($pdo, $userId, 23);
                    }
                }
            }
            break;
    
    case 'rmdir':
            if (count($args) > 2) {
                $output = "Error: Invalid rmdir command";
                break;
            }
            $output = process_rmdir($fileSystem, $currentDir, $arg);
            if ($lessonID === 24 && $GLOBALS['commandSuccess'] && ($arg === "project1/" || $arg === "project1")) {
                $isCorrect = true; 
                if ($userId !== null) {
                    update_mysql($pdo, $userId, 24, 25); 
                    updateUserProgress($pdo, $userId, 24);
                }
            }
            break;
    
     case 'grep':
            $flag = ($arg && str_starts_with($arg, "-")) ? $arg : "";
            $pattern = $flag ? $arg2 : $arg;
            $file = $flag ? $arg3 : $arg2;
            if (count($args) < 3 || count($args) > 4) {
                $output = "Error: Invalid grep command\n";
                break;
            }
            $output = process_grep($fileSystem, $currentDir, $flag, $pattern, $file);
            if ($lessonID === 39 && $pattern === "And" && $file === "Shakespeare.txt" && !str_starts_with($output, "Error:")) {
                  $isCorrect = true;
                  if ($userId !== null) {
                      update_mysql($pdo, $userId, 39, 40);
                      updateUserProgress($pdo, $userId, 39);
                  }
            }
            if ($lessonID === 40 && $flag === "-n" && $pattern === "in" && $file === "Declaration.txt" && !str_starts_with($output, "Error:")) {
                $isCorrect = true;
                if ($userId !== null) {
                    update_mysql($pdo, $userId, 40, 41);
                    updateUserProgress($pdo, $userId, 40);
                }
            }
            if ($lessonID === 41 && $flag === "-c" && $pattern === "moon" && $file === "Kennedy.txt" && !str_starts_with($output, "Error:")) {
                $isCorrect = true;
                if ($userId !== null) {
                    update_mysql($pdo, $userId, 41, 42);
                    updateUserProgress($pdo, $userId, 41);
                }
            }
            if ($lessonID === 42 && $pattern === "all" && $file === "*.txt" && !str_starts_with($output, "Error:")) {
                $isCorrect = true;
                if ($userId !== null) {
                    update_mysql($pdo, $userId, 42, 43);
                    updateUserProgress($pdo, $userId, 42);
                }
            }
            if ($lessonID == 56 && $flag === "-n" && $pattern === "we" && $file === "Declaration.txt" && !str_starts_with($output, "Error:")) {
                $isCorrect = true;
                if ($userId !== null) {
                    update_mysql($pdo, $userId, 56, 57);
                    updateUserProgress($pdo, $userId, 56);
                } 
            }
            if ($lessonID == 57 && $flag === "-c" && $pattern === "happen" && $file === "LetItHappen.txt" && !str_starts_with($output, "Error:")) {
                $isCorrect = true;
                if ($userId !== null) {
                    update_mysql($pdo, $userId, 57, 58);
                    updateUserProgress($pdo, $userId, 57);
                } 
            }
            break;
    case 'find':
            if (count($args) < 3 || count($args) > 4) {
                $output = "Error: Invalid find command\"\n";
                break;
            }
            $path = $args[1];
            $expression = $args[count($args) - 1];
            if ($args[2] === '-name' && count($args) >= 4) {
                $expression = $args[3];
            }
            $expression = trim($expression, "\"'");
            $output = process_find($fileSystem, $currentDir, $path, $expression);
            if ($lessonID === 44 && strpos($output, "Documents/Lyrics/LetItHappen.txt") !== false) {
                $isCorrect = true;
                if ($userId !== null) {
                    update_mysql($pdo, $userId, 44, 45);
                    updateUserProgress($pdo, $userId, 44);
                }
            }
    
            if ($lessonID === 45 && strpos($output, 'Projects/project1') !== false) {
                $isCorrect = true;
                if ($userId !== null) {
                    update_mysql($pdo, $userId, 45, 46);
                    updateUserProgress($pdo, $userId, 45);
                }
            }
    
            if ($lessonID === 60 && ($path === "Documents" || $path === "Documents/") && $expression === "*.txt") {
                $isCorrect = true;
                if ($userId !== null) {
                    update_mysql($pdo, $userId, 60, 61);
                    updateUserProgress($pdo, $userId, 60);
                }
            }
            break;
    case 'sort':
        if (substr($arg, 0, 1) === '-') {
            // $arg is flags, $arg2 is filename
            $output = process_sort($fileSystem, $currentDir, $arg, $arg2);
            if ($lessonID === 47 && $arg === "-r" && $arg2 === "grocery_list.txt" && !str_starts_with($output, "Error:")) { 
                $isCorrect = true;
                if ($userId !== null) {
                update_mysql($pdo, $userId, 47, 48);
                updateUserProgress($pdo, $userId, 47);
                }
            }
        } else {
            // $arg is filename, no flags
            $output = process_sort($fileSystem, $currentDir, '', $arg);
            if ($lessonID === 46 && $arg === "grocery_list.txt" && !str_starts_with($output, "Error:")) {
                $isCorrect = true;
                if ($userId !== null) {
                    update_mysql($pdo, $userId, 46, 47);
                    updateUserProgress($pdo, $userId, 46);
                }
            }
        }
        break;
    case 'wc':
            if (count($args) > 3) return "Error: Too many <wc> arguments in this enviroment";
            if (count($args) === 2) {
                $output = process_wc($fileSystem, $currentDir, "", $arg);
                if ($lessonID === 78 && $arg === "Declaration.txt") {
                    $isCorrect = true;
                    if ($userId) {
                        update_mysql($pdo, $userId, 78, 79);
                        updateUserProgress($pdo, $userId, 78);
                    }
                }
                if ($lessonID === 80 && $arg === "*.txt" && !str_contains($output, '0')) {
                     $isCorrect = true;   
                    if ($userId) {
                        update_mysql($pdo, $userId, 80, 81);
                        updateUserProgress($pdo, $userId, 80);   
                    }
                }
            }
            if (count($args) === 3) {
                $output = process_wc($fileSystem, $currentDir, $arg, $arg2);
                    if ($lessonID === 79 && !str_contains($output, '0') && ($arg === "-l" || $arg === "-w" || $arg === "-c") && $arg2 === "Kennedy.txt") {
                        $isCorrect = true;
                        if ($userId) {
                            update_mysql($pdo, $userId, 79, 80);
                            updateUserProgress($pdo, $userId, 79);
                        }
                    }
            }
            break;
    case 'chmod':
        $output = process_chmod($fileSystem, $currentDir, "no_sudo", $arg, $arg2);
        if (count($args) < 3 || count($args) > 4) {
            $output = "Error: Invalid Chmod Command";
            break;
        }
        if (str_starts_with($output, "Error:")) {
            break;
        }
       if ($lessonID === 70 && !contains_number($arg)) {
            $output = "For this lab please use octal mode\n";
            break;
        }
        if ($lessonID === 70 && $arg === "633" && $arg2 === "sales_report.txt") {
            $isCorrect = true;
            if ($userId !== null) {
                update_mysql($pdo, $userId, 70, 70);
                updateUserProgress($pdo, $userId, 70);
            }
        }
        break;
    case 'chown':
        $output = process_chown($fileSystem, $currentDir, "no_sudo", $arg,  $arg2);
        break;
    case 'sudo':
            if ($arg !== "chmod" && $arg !== "chown") {
                $output = "Only chmod and chown are supported with sudo in this setting";
                break;
            }
        
            if (count($args) !== 4) {
                $output = "Error: Invalid Sudo Command";
                break;
            }
        
            if ($arg === "chmod") {
                $output = process_chmod($fileSystem, $currentDir, "sudo", $arg2, $arg3);
                if ($lessonID === 67 && $arg2 === "u+r" && $arg3 === "daily_logs.txt") {
                    $isCorrect = true;
                    if ($userId !== null) {
                        update_mysql($pdo, $userId, 67, 68);
                        updateUserProgress($pdo, $userId, 67);
                    }
                }
                if ($lessonID === 56 && $arg2 === "g+w" && $arg3 === "sales_report.txt") {
                    $isCorrect = true;
                    if ($userId !== null) {
                        update_mysql($pdo, $userId, 68, 68);
                        updateUserProgress($pdo, $userId, 69);
                    }
                }
                if ($lessonID == 65 && contains_number($arg2) === false) {
                    $output = "For this lab please octal mode";
                    break;
                }
                if ($lessonID === 65 && $arg2 === "633" && $arg3 === "sales_report.txt") {
                    $isCorrect = true;
                    if ($userId !== null) {
                        update_mysql($pdo, $userId, 65, 65);
                        updateUserProgress($pdo, $userId, 65);
                    }
                }
            }
            if ($arg === "chown") {
                $output = process_chown($fileSystem, $currentDir, "sudo", $arg2,  $arg3);
                  if ($lessonID === 70 && $arg3 === "daily_logs.txt") {
                    $isCorrect = true;
                    if ($userId !== null) {
                        update_mysql($pdo, $userId, 70, 71);
                        updateUserProgress($pdo, $userId, 70);
                    }
                }
            }
    break;
case 'python3': 
    $perms = GetFilePermissions($fileSystem, $currentDir, "revenue.py");
    if ($perms === "-") { 
        $output = "Error: User does not have permission to execute revenue.py";
        break;
    }
    if ($lessonID === 76 && $arg === "revenue.py") { 
           $output = shell_exec('python3 sales.py');
           $isCorrect = true;
           if ($userId !== null) {
               update_mysql($pdo, $userId, 76, 77);
               updateUserProgress($pdo, $userId, 76);
        }
    }
    else {
            $output = "Error: File Does Not Exist";
    } 
       break;
    case 'refresh':
        $output = process_refresh();
        break;
	case 'ping':
        $output = process_ping($arg);
        if ($lessonID === 6 && ($arg === "google.com" || $arg === "142.250.72.206")) {
            $isCorrect = true;
            if ($userId) {
                network_update_mysql($pdo, $userId, 6, 7);
                network_updateUserProgress($pdo, $userId, 6);
            }
        } 
        break;
    case 'ip':
            if ($arg === "route") {
                $output = process_ip_route();
                if ($lessonID === 13) {
                    $isCorrect = true;
                if ($userId) {
                    network_update_mysql($pdo, $userId, 13, 14);
                    network_updateUserProgress($pdo, $userId, 13);
                }
            }
                break;
            }
            else $output = "Invalid ip command";
            break;
    case 'ifconfig': 
        $output = process_ifconfig();
        if ($lessonID === 5) {
            $isCorrect = true;
            if ($userId) {
                network_update_mysql($pdo, $userId, 5, 6);
                network_updateUserProgress($pdo, $userId, 5);
            }
        } 
        break;
    case 'traceroute':
        $output = process_traceroute($arg);
        if ($arg === "google.com") {
            $isCorrect = true;
            if ($userId) {
                network_update_mysql($pdo, $userId, 13, 14);
                network_updateUserProgress($pdo, $userId, 13);
            }
        }
	    break;
	case 'nslookup':
        $command = implode(' ', array_map('strtolower', $args));
        $shell = shell_exec($command);
        $output = $shell;
        if ($lessonID === 12 && $command === "nslookup google.com") {
            $isCorrect = true;
            if ($userId) {
                network_update_mysql($pdo, $userId, 8, 9);
                network_updateUserProgress($pdo, $userId, 8);
            }
        }
        break;
     case 'netstat':
        $command = implode(' ', array_map('strtolower', $args));
        $output = shell_exec($command);
        break;
    case 'ss':
        $command = implode(' ', array_map('strtolower', $args));
        $output = shell_exec($command);
        if ($lessonID === 24 && $command === "ss -tuln") {
            $isCorrect = true;
            if ($userId) {
                network_update_mysql($pdo, $userId, 24, 25);
                network_updateUserProgress($pdo, $userId, 24);
            }
        }

    case 'host':
    $output =  shell_exec("nslookup www.alphavantage.com");
    break;
    case 'telnet':
        $command = implode(' ', array_map('strtolower', $args));
        $shell = shell_exec($command);
        $output = $shell;
        if ($lessonID === 22 && $command === "telnet google.com 80") {
            $isCorrect = true;
            if ($userId) {
                network_update_mysql($pdo, $userId, 22, 23);
                network_updateUserProgress($pdo, $userId, 22);
            }
        }
        break;
    case 'curl':
        $command = implode(' ', $args);
        $shell = shell_exec(implode(' ', $args));
        $output = $shell;
        if ($lessonID === 31 && $command === "curl https://www.oracle.com") {
            $isCorrect = true;
            if ($userId) {
                network_update_mysql($pdo, $userId, 31, 32);
                network_updateUserProgress($pdo, $userId, 31); 
            }
        }
        if ($lessonID === 32 && $command === "curl -I https://www.google.com") {
            $isCorrect = true;
            if ($userId) {
                network_update_mysql($pdo, $userId, 32, 33);
                network_updateUserProgress($pdo, $userId, 32); 
            }
        }
        if ($lessonID === 34 && $command === "curl https://www.alphavantage.co/query?function=GLOBAL_QUOTE&symbol=GOOG&apikey=VVPWAF4272QM01N9") {
            $isCorrect = true;
            if ($userId) {
                network_update_mysql($pdo, $userId, 34, 35);
                network_updateUserProgress($pdo, $userId, 34); 
            }
        }
        if ($lessonID === 36 && $command === "curl ifconfig.me") {
            $isCorrect = true;
            if ($userId) {
                network_update_mysql($pdo, $userId, 36, 37);
                network_updateUserProgress($pdo, $userId, 36); 
            }
        }
        break;
    case 'wget':
        $output = process_wget($fileSystem, $currentDir, $arg);
        break;
    
    default:
            $output = "Command not recognized: $cmd\n";
            break;
    }

    if (isset($_SESSION["user_username"]) && !empty($_SESSION["user_username"])) {
        $progress = send_user_progress($pdo, $userId);
        $currentLesson = send_current_lesson($pdo, $userId);
        $status = send_user_status($pdo, $username);
    }
   
    if (!isset($_SESSION["user_username"]) || empty($_SESSION["user_username"])) {
        $progress = null;
        $currentLesson = null;
        $status = null;
    }

 
$multi_answer = GetMultChoiceAnswer($lessonID);
   // Return the output as JSON
    echo json_encode([
        'output' => $output,
        'commandSuccess' => $isCorrect,
        'currentDirectory' => $currentDir,
        'userProgress' => $progress,
        'userCurrentLesson' => $currentLesson,
        'userStatus' => $status,
        "answer" => $multi_answer,
    ]);
} 
