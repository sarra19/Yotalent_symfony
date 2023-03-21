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
public class Participation {
     private int  idP,nbRemb;
     private Evenement idEv;
     private User idU;
     private EspaceTalent idT;

    public Participation() {
    }
    

    public Participation(int nbRemb, Evenement idEv, User idU, EspaceTalent idT) {
        this.nbRemb = nbRemb;
        this.idEv = idEv;
        this.idU = idU;
        this.idT = idT;
    }
    
    

    public Participation(int idP, int nbRemb) {
        this.idP = idP;
        this.nbRemb = nbRemb;
    }
    

    public Participation(int idP, int nbRemb, Evenement idEv, User idU, EspaceTalent idT) {
        this.idP = idP;
        this.nbRemb = nbRemb;
        this.idEv = idEv;
        this.idU = idU;
        this.idT = idT;
    }

    public int getIdP() {
        return idP;
    }

    public void setIdP(int idP) {
        this.idP = idP;
    }

    public int getNbRemb() {
        return nbRemb;
    }

    public void setNbRemb(int nbRemb) {
        this.nbRemb = nbRemb;
    }

    public Evenement getIdEv() {
        return idEv;
    }

    public void setIdEv(Evenement idEv) {
        this.idEv = idEv;
    }

    public User getIdU() {
        return idU;
    }

    public void setIdU(User idU) {
        this.idU = idU;
    }

    public EspaceTalent getIdT() {
        return idT;
    }

    public void setIdT(EspaceTalent idT) {
        this.idT = idT;
    }

    @Override
    public String toString() {
        return "Participation{" + "idP=" + idP + ", nbRemb=" + nbRemb + ", idEv=" + idEv + ", idU=" + idU + ", idT=" + idT + '}';
    }

    @Override
    public int hashCode() {
        int hash = 5;
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
        final Participation other = (Participation) obj;
        if (this.idP != other.idP) {
            return false;
        }
        if (this.nbRemb != other.nbRemb) {
            return false;
        }
        if (!Objects.equals(this.idEv, other.idEv)) {
            return false;
        }
        if (!Objects.equals(this.idU, other.idU)) {
            return false;
        }
        if (!Objects.equals(this.idT, other.idT)) {
            return false;
        }
        return true;
    }
     
    
}
