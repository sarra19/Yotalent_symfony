/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.YoTalent.entities;

/**
 *
 * @author USER
 */
public class Role {
    private int idRole;
    private String nomAdmin;
    private String nomSociete;
    private String nomClient;

    public Role() {
    }

    public Role(String nomAdmin, String nomSociete, String nomClient) {
        this.nomAdmin = nomAdmin;
        this.nomSociete = nomSociete;
        this.nomClient = nomClient;
    }
    
    

    public Role(int idRole, String nomAdmin, String nomSociete, String nomClient) {
        this.idRole = idRole;
        this.nomAdmin = nomAdmin;
        this.nomSociete = nomSociete;
        this.nomClient = nomClient;
    }
    
    
    
}
