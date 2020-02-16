###GGG:thirst system
(try_begin),
	(gt, ":agent_id", 0),
	(agent_is_human, ":agent_id"),
	(agent_get_player_id, ":player_id", ":agent_id"),
	(player_is_active, ":player_id"),
	(agent_get_slot, ":water_amount", ":agent_id", slot_agent_water_amount),

	(try_begin),
	   (gt, ":water_amount", 0), 
	   (try_begin), 
		   (gt, ":water_amount", 0.25),
		   (val_sub, ":water_amount", 0.25), #
		(else_try),
		   (le, ":water_amount", 0.25),
		   (assign, ":water_amount", 0), 
	   (try_end),
	   (agent_set_slot, ":agent_id", slot_agent_water_amount, ":water_amount"), 
	(try_end),

	(store_mod, ":remainder", ":water_amount", 2),
	(eq, ":remainder", 0),
	(multiplayer_send_3_int_to_player, ":player_id", server_event_agent_set_slot, ":agent_id", slot_agent_water_amount, ":water_amount"),
(try_end),
###GGG

####出生与保存

game_receive_url_response
	 (agent_set_slot, ":agent_id", slot_agent_water_amount, ":water_amount"),
	 (multiplayer_send_3_int_to_player, ":player_id", server_event_agent_set_slot, ":agent_id", slot_agent_water_amount, ":water_amount"),

player_respawn_in_place
    (agent_get_slot, ":water_amount", ":agent_id", slot_agent_water_amount),
    (player_set_slot, ":player_id", slot_player_spawn_water_amount, ":water_amount"),
    (multiplayer_send_3_int_to_player, ":player_id", server_event_player_set_slot, ":player_id", slot_player_spawn_water_amount, ":water_amount"),

on_agent_spawned 
      (player_is_active, ":player_id"),
      (player_get_slot, ":water_amount", ":player_id", slot_player_spawn_water_amount),
      (try_begin),
        (gt, ":water_amount", 0),
        (agent_set_slot, ":agent_id", slot_agent_water_amount, ":water_amount"),
        (player_set_slot, ":player_id", slot_player_spawn_water_amount, 0),
      (try_end),

cf_save_player_exit
			(agent_get_slot, ":water_amount", ":agent_id", slot_agent_water_amount),
			(assign, reg19, ":water_amount"),

#####吃

  ("cf_eat_food", # server: handle players consuming food items
   [(multiplayer_is_server),
    (store_script_param, ":agent_id", 1), # must be valid
    (store_script_param, ":item_id", 2),

    (agent_is_alive, ":agent_id"),
    (agent_get_action_dir, ":direction", ":agent_id"),
    (eq, ":direction", 0),
    (call_script, "script_cf_agent_consume_item", ":agent_id", ":item_id", 1),
    (item_get_slot, ":food", ":item_id", slot_item_resource_amount),
    (gt, ":food", 0),
    ###GGG:thirst system
    (try_begin),
        (try_begin),
            (eq, ":item_id", "itm_beer_jug"),
            (assign, ":water", 25),
        (else_try),
            (eq, ":item_id", "itm_wine_jar"),
            (assign, ":water", 50),
        (try_end),
        (agent_get_slot, ":water_amount", ":agent_id", slot_agent_water_amount),
        (lt, ":water_amount", max_food_amount),
        (val_add, ":water_amount", ":water"),
        (val_min, ":water_amount", max_food_amount),
        (agent_set_slot, ":agent_id", slot_agent_water_amount, ":water_amount"),
        (agent_get_player_id, ":player_id", ":agent_id"),
        (player_is_active, ":player_id"),
        (multiplayer_send_3_int_to_player, ":player_id", server_event_agent_set_slot, ":agent_id", slot_agent_water_amount, ":food_amount"),     
    (try_end),    
    ###GGG
    (agent_get_slot, ":food_amount", ":agent_id", slot_agent_water_amount),
    (lt, ":food_amount", max_food_amount),
    (val_add, ":food_amount", ":food"),
    (val_min, ":food_amount", max_food_amount),
    (agent_set_slot, ":agent_id", slot_agent_water_amount, ":food_amount"),
    (agent_get_player_id, ":player_id", ":agent_id"),
    (player_is_active, ":player_id"),
    (multiplayer_send_3_int_to_player, ":player_id", server_event_agent_set_slot, ":agent_id", slot_agent_water_amount, ":food_amount"),

    (try_begin),

    (try_end),
    ]),