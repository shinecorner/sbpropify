
INSERT INTO `service_request_categories` (`id`, `parent_id`, `name`, `name_de`, `name_fr`, `name_it`, `room`, `location`, `description`, `has_qualifications`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 'Defect', 'Defekt / Mangel', 'Imperfection / Brièveté', 'Imperfezione / Brevità', 0, 0, NULL, 1, '2019-08-06 04:31:49', '2019-08-20 18:52:09', NULL),
(3, NULL, 'Order documents', 'Dokumente bestellen', 'Commander des documents', 'Ordina documenti', 0, 0, NULL, 0, '2019-08-06 04:31:49', '2019-08-19 14:52:25', NULL),
(4, NULL, 'Questions about additional costs', 'Fragen zu Nebenkosten', 'Questions sur les coûts supplémentaires', 'Domande sui costi aggiuntivi', 0, 0, NULL, 0, '2019-08-06 04:31:49', '2019-08-19 14:55:02', NULL),
(5, NULL, 'Questions about the tenancy', 'Fragen zum Mietverhältnis', 'Questions sur la location', 'Domande sul noleggio', 0, 0, NULL, 0, '2019-08-06 04:31:49', '2019-08-19 14:52:17', NULL),
(6, NULL, 'Key loss / order', 'Schlüsselverlust/-bestellung', 'Perte de clé / commande', 'Perdita del tasto / comando', 0, 0, NULL, 0, '2019-08-06 04:31:49', '2019-08-19 14:54:48', NULL),
(7, 1, 'Surrounding', 'Umgebung', 'Avoisinantes', 'Donne vicine', 0, 0, NULL, 1, '2019-08-06 04:31:49', '2019-08-19 14:50:59', NULL),
(8, 1, 'Real estate', 'Liegenschaft', 'Biens immobiliers', 'Immobili', 0, 1, NULL, 1, '2019-08-06 04:31:49', '2019-08-19 14:53:01', NULL),
(9, 1, 'Flat', 'Wohnung', 'Logement', 'Alloggiamento', 1, 0, NULL, 1, '2019-08-06 04:31:49', '2019-08-19 14:53:07', NULL),
(13, NULL, 'Order inpayment slips', 'Einzahlungsscheine bestellen', 'Commander des bulletins de versement', 'Bollettini di pagamento dell\'ordine', 0, 0, NULL, 0, '2019-08-19 14:52:54', '2019-08-19 14:52:54', NULL),
(15, NULL, 'Other', 'Anderes', 'Autre', 'Altro', 0, 0, NULL, 0, '2019-08-20 16:23:13', '2019-08-20 16:23:13', NULL);
