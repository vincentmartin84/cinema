-- afficher la liste des réalisateurs d'un film
select * 
from film,participer,individu 
where fil_id=par_film and par_individu=ind_id
and par_fonction='réalisateur';
-- afficher la liste des acteurs d'un film
select * 
from film,participer,individu 
where fil_id=par_film and par_individu=ind_id
and par_fonction='acteur'
order by fil_id;
-- afficher la liste des films d'un réalisateur
select *
from participer, individu, film
where fil_id=par_film and par_individu=ind_id 
and par_fonction='réalisateur'
order by par_individu;
-- afficher la liste des films d'un acteur
select *
from participer, individu, film
where fil_id=par_film and par_individu=ind_id 
and par_fonction='acteur'
order by par_individu;
-- afficher le nombre de films réalisés par réalisateur.
select ind_nom, par_individu, count(par_id) nb
from participer, individu
where par_individu=ind_id and par_fonction='réalisateur'
group by par_individu
order by nb desc;
-- afficher le nombre de films par acteur.
select ind_nom, par_individu, par_fonction, count(par_id) nb
from individu left join participer on par_individu=ind_id
group by par_individu, par_fonction;
-- afficher dans combien de cinéma chaque film a été projeté.
select fil_nom,pro_film, count(pro_cinema) nb
from projeter, film
where pro_film=fil_id
group by pro_film
order by nb desc;
-- afficher combien de films seront projetés le 24/12/2022.
select count(distinct pro_film)
from projeter
where "2022-12-24" between pro_date_debut and pro_date_fin;
-- afficher combien de films seront projetés entre le 24/12/2022 et le 31/12/2022.
-- -----------------------------24----------------31--------------
-- --------------DB----------DF------------------------------------
-- --------------------------------------------------DB----------DF---
select count(distinct pro_film)
from projeter
where not (pro_date_fin<"2022-12-24" or pro_date_debut>"2022-12-31");
-- afficher le nombre de jours où un film est joué dans un cinéma en moyenne
select pro_film, avg(datediff(pro_date_fin,pro_date_debut)) moyenne
from projeter
group by pro_film
order by moyenne desc;
-- afficher par mois, pour l'année 2022, le nombre de salles où un film est joué.
select pro_film,month(pro_date_debut) mois, count(pro_cinema)
from projeter
where year(pro_date_fin)=2022
group by pro_film,mois;
-- quel cinéma a projeté le plus de film
select pro_cinema, count(pro_film) nb
from projeter
group by pro_cinema
order by nb desc;
