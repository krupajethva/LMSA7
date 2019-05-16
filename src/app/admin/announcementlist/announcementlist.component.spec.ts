import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AnnouncementlistComponent } from './announcementlist.component';

describe('AnnouncementlistComponent', () => {
  let component: AnnouncementlistComponent;
  let fixture: ComponentFixture<AnnouncementlistComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AnnouncementlistComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AnnouncementlistComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
