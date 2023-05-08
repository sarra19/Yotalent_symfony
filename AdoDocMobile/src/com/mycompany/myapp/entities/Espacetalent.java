/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.myapp.entities;

/**
 *
 * @author MSI GF63
 */
import java.util.Date;

/**
 *
 * @razi sniha
 */
public class Espacetalent {
    private int idEST;
    private String username;
      private String image;

    private int nbVotes;
        private int idCat;
         private int idU;

    public Espacetalent() {
    }

    public Espacetalent(String username, String image, int nbVotes) {
        this.username = username;
        this.image = image;
        this.nbVotes = nbVotes;
    }
    
    

    public Espacetalent(String username, String image, int nbVotes, int idCat, int idU) {
        this.username = username;
        this.image = image;
        this.nbVotes = nbVotes;
        this.idCat = idCat;
        this.idU = idU;
    }
    

    public Espacetalent(String username) {
        this.username = username;
    }

    public Espacetalent(int idEST, String username, String image, int nbVotes, int idCat, int idU) {
        this.idEST = idEST;
        this.username = username;
        this.image = image;
        this.nbVotes = nbVotes;
        this.idCat = idCat;
        this.idU = idU;
    }

    public int getIdEST() {
        return idEST;
    }

    public void setIdEST(int idEST) {
        this.idEST = idEST;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getImage() {
        return image;
    }

    public void setImage(String image) {
        this.image = image;
    }

    public int getNbVotes() {
        return nbVotes;
    }

    public void setNbVotes(int nbVotes) {
        this.nbVotes = nbVotes;
    }

    public int getIdCat() {
        return idCat;
    }

    public void setIdCat(int idCat) {
        this.idCat = idCat;
    }

    public int getIdU() {
        return idU;
    }

    public void setIdU(int idU) {
        this.idU = idU;
    }

    @Override
    public String toString() {
        return "Espacetalent{" + "idEST=" + idEST + ", username=" + username + ", image=" + image + ", nbVotes=" + nbVotes + ", idCat=" + idCat + ", idU=" + idU + '}';
    }
    


    
    
}
