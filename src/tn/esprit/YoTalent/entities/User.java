/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.YoTalent.entities;

import java.util.Objects;

/**
 *
 * @author USER
 */
public class User {
    private int idU;
    private String nomU;
    private String email;
   

    public User() {
    }

    public User(int idU) {
        this.idU = idU;
    }

    public User(String nomU, String email) {
        this.nomU = nomU;
        this.email = email;
    }

    public User(int idU, String nomU, String email) {
        this.idU = idU;
        this.nomU = nomU;
        this.email = email;
    }

    public int getIdU() {
        return idU;
    }

    public void setIdU(int idU) {
        this.idU = idU;
    }

    public String getNomU() {
        return nomU;
    }

    public void setNomU(String nomU) {
        this.nomU = nomU;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    @Override
    public int hashCode() {
        int hash = 7;
        return hash;
    }

    @Override
    public boolean equals(Object obj) {
        if (obj == null) {
            return false;
        }
        if (getClass() != obj.getClass()) {
            return false;
        }
        final User other = (User) obj;
        if (this.idU != other.idU) {
            return false;
        }
        if (!Objects.equals(this.nomU, other.nomU)) {
            return false;
        }
        if (!Objects.equals(this.email, other.email)) {
            return false;
        }
        return true;
    }

    @Override
    public String toString() {
        
        return String.valueOf(idU);
    }
    
  
}

