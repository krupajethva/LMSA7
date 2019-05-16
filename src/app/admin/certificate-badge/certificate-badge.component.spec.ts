import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CertificateBadgeComponent } from './certificate-badge.component';

describe('CertificateBadgeComponent', () => {
  let component: CertificateBadgeComponent;
  let fixture: ComponentFixture<CertificateBadgeComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CertificateBadgeComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CertificateBadgeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
