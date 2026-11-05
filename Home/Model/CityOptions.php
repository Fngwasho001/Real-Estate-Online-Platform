<?php
// Include Necessary Classes
include_once('DbConnection.php');

class CityOptions extends DbConnection
{
    private $cities = [
        ['value' => 'any', 'label' => 'Any'],
        ['value' => 'london', 'label' => 'London'],
        ['value' => 'birmingham', 'label' => 'Birmingham'],
        ['value' => 'manchester', 'label' => 'Manchester'],
        ['value' => 'glasgow', 'label' => 'Glasgow'],
        ['value' => 'edinburgh', 'label' => 'Edinburgh'],
        ['value' => 'bristol', 'label' => 'Bristol'],
        ['value' => 'leeds', 'label' => 'Leeds'],
        ['value' => 'sheffield', 'label' => 'Sheffield'],
        ['value' => 'liverpool', 'label' => 'Liverpool'],
        ['value' => 'newcastle', 'label' => 'Newcastle'],
        ['value' => 'nottingham', 'label' => 'Nottingham'],
        ['value' => 'southampton', 'label' => 'Southampton'],
        ['value' => 'leicester', 'label' => 'Leicester'],
        ['value' => 'coventry', 'label' => 'Coventry'],
        ['value' => 'kingston_upon_hull', 'label' => 'Kingston upon Hull'],
        ['value' => 'cardiff', 'label' => 'Cardiff'],
        ['value' => 'belfast', 'label' => 'Belfast'],
        ['value' => 'derby', 'label' => 'Derby'],
        ['value' => 'reading', 'label' => 'Reading'],
        ['value' => 'swindon', 'label' => 'Swindon'],
        ['value' => 'wolverhampton', 'label' => 'Wolverhampton'],
        ['value' => 'stoke_on_trent', 'label' => 'Stoke-on-Trent'],
        ['value' => 'woking', 'label' => 'Woking'],
        ['value' => 'luton', 'label' => 'Luton'],
        ['value' => 'maidstone', 'label' => 'Maidstone'],
        ['value' => 'cambridge', 'label' => 'Cambridge'],
        ['value' => 'oxford', 'label' => 'Oxford'],
        ['value' => 'bournemouth', 'label' => 'Bournemouth'],
        ['value' => 'guildford', 'label' => 'Guildford'],
        ['value' => 'brighton', 'label' => 'Brighton'],
        ['value' => 'exeter', 'label' => 'Exeter'],
        ['value' => 'norwich', 'label' => 'Norwich'],
        ['value' => 'wakefield', 'label' => 'Wakefield'],
        ['value' => 'hartlepool', 'label' => 'Hartlepool'],
        ['value' => 'chester', 'label' => 'Chester'],
        ['value' => 'durham', 'label' => 'Durham'],
        ['value' => 'gloucester', 'label' => 'Gloucester'],
        ['value' => 'salford', 'label' => 'Salford'],
        ['value' => 'blackpool', 'label' => 'Blackpool'],
        ['value' => 'warrington', 'label' => 'Warrington'],
        ['value' => 'stockport', 'label' => 'Stockport'],
        ['value' => 'dudley', 'label' => 'Dudley'],
        ['value' => 'redditch', 'label' => 'Redditch'],
        ['value' => 'wokingham', 'label' => 'Wokingham'],
        ['value' => 'tamworth', 'label' => 'Tamworth'],
        ['value' => 'newport', 'label' => 'Newport'],
        ['value' => 'weston_super_mare', 'label' => 'Weston-super-Mare'],
        ['value' => 'worcester', 'label' => 'Worcester'],
        ['value' => 'st_helens', 'label' => 'St Helens'],
        ['value' => 'tonbridge', 'label' => 'Tonbridge'],
        ['value' => 'harrogate', 'label' => 'Harrogate'],
        ['value' => 'hastings', 'label' => 'Hastings'],
        ['value' => 'swansea', 'label' => 'Swansea'],
        ['value' => 'brighton', 'label' => 'Brighton'],
        ['value' => 'colchester', 'label' => 'Colchester']
    ];
    
    public function getCities() {
        return $this->cities;
    }
}
