<?php
/**
 * @api {get} /stats/usagers Recuperer les statistiques des usagers.
 * @apiName GetStatsUsagers
 * @apiGroup Stats
 * 
 * @apiSuccess {int} HommeAvant25  le nombre de rdv des patients hommes de moins de 25 ans.
 * @apiSuccess {int} HommeAvant50  le nombre de rdv des patients hommes entre 25 et 50 ans.
 * @apiSuccess {int} HommeApres50  le nombre de rdv des patients hommes de plus de 50 ans.
 * @apiSuccess {int} FemmeAvant25  le nombre de rdv des patients femmes de moins de 25 ans.
 * @apiSuccess {int} FemmeAvant50  le nombre de rdv des patients femmes entre 25 et 50 ans.
 * @apiSuccess {int} FemmeApres50  le nombre de rdv des patients femmes de plus de 50 ans.
 * @apiSuccessExample Success-Response:
 * status_code: 200,
 * status_message: "[R401 Rest API] Statistiques",
 * {
 *  "status_code": 200,
 *  "status_message": null,
 *    "data": {
 *         "HommeAvant25": 0,
 *         "HommeAvant50": 0,
 *         "HommeApres50": 3,
 *         "FemmeAvant25": 0,
 *         "FemmeAvant50": 0,
 *         "FemmeApres50": 0
 *     }
 * }
 */ 
 /** @api {get} /stats/medecins Recuperer les statistiques des medecins.
 * @apiName GetStatsMedecin
 * @apiGroup Stats
 * 
 * @apiSuccess {int} id  id du medecin
 * @apiSuccess {int} total nombre de minutes de consultations
 * @apiSuccessExample Success-Response:
 * {
 * status_code: 200,
 * status_message: "[R401 Rest API] Statistiques",
 * data:{
 *     "1": 10,
 *     "2": 20,
 * }
 * }
 * 
 */
