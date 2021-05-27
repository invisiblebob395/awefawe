#!/usr/bin/python -tt

from module_items import *
from header_items import *
import argparse

parser = argparse.ArgumentParser(description="Dump item ids with names, for use with the administrator items tool.")
parser.add_argument("output_file", nargs='?', default="admin_item_ids", help="file name without extension")
args = parser.parse_args()

with open(args.output_file + ".txt", "w") as f:
	string = ""
	for i, item in enumerate(items):
		type = item[3] & 0x1f
		string += str(i) + "," + item[0] + "," + item[1] + ',' + str(type)
		dic = {}
		if type == 1: 
			dic = {'HP' : get_hit_points(item[6]), 'armor' : get_body_armor(item[6]), 'difficulty' : get_difficulty(item[6]), 'speed' : get_missile_speed(item[6]), 'maneuver' : get_speed_rating(item[6]), 'charge' : get_thrust_damage(item[6])}
		elif type == 2 or type == 3 or type == 4:
			dic = {'speed' : get_speed_rating(item[6]), 'length' : get_weapon_length(item[6]), 'swing' : get_damage_str(get_swing_damage(item[6])), 'thrust' : get_damage_str(get_thrust_damage(item[6]))}
		elif type == 5 or type == 6 or type == 10 or type == 0x0000000000000012:
			dic = {'thrust' : get_damage_str(get_thrust_damage(item[6])), 'ammo' : get_max_ammo(item[6])}
		elif type == 7:
			dic = {'weight' : get_weight(item[6]), 'HP': get_hit_points(item[6]), 'armor' : get_body_armor(item[6])}
		elif type == 0x0000000000000008 or type == 9 or type == 10 or type == 11:
			dic = {'length' : get_weapon_length(item[6]), 'speed' : get_speed_rating(item[6]), 'shoot_speed' : get_missile_speed(item[6]), 'thrust' : get_damage_str(get_thrust_damage(item[6])), 'ammo' : get_max_ammo(item[6])}
		elif type == 0x000000000000000c:
			dic = {'head_armor' : get_head_armor(item[6])}
		elif type == 0x000000000000000d:
			dic = {'body_armor' : get_body_armor(item[6]), "leg_armor" : get_leg_armor(item[6])}
		elif type == 0x000000000000000e:
			dic = {'leg_armor' : get_leg_armor(item[6])}
		elif type == 0x000000000000000f:
			dic = {'body_armor' : get_body_armor(item[6])}

		for key in dic:
			if isinstance(dic[key], long):
				dic[key] = int(dic[key])
		string += "," + str(dic) + "\n"
	f.write(string)
	    #if (item[3] == itp_type_hand_armor and get_body_armor(item[6])) >= 3: string += str(i) + "|"

  #string = string[:len(string) - 1]
	print(string)